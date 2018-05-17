<?php

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use GuzzleHttp\Client as GuzzleHttpClient;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function (Request $request) {
    $client = new GuzzleHTTPClient();
    $response = $client->get('https://vendorlist.consensu.org/vendorlist.json');
    $rawVendorList = json_decode($response->getBody()->getContents(), true);
    $vendorList = [];
    
    foreach ($rawVendorList['vendors'] as $id => $vendor) {
        $purposes = [];
        foreach ($vendor['purposeIds'] as $purpose) {
            if (isset($rawVendorList['purposes'][$purpose])) {
                $purposes[] = e($rawVendorList['purposes'][$purpose]['name']);
            } else {
                $purposes[] = e('Unknown Purpose');
            }
        }
        if (count($purposes) === 0) {
            $purposes[] = 'None';
        }
        
        $legitimateInterestPurposes = [];
        foreach ($vendor['legIntPurposeIds'] as $purpose) {
            if (isset($rawVendorList['purposes'][$purpose])) {
                $legitimateInterestPurposes[] = e($rawVendorList['purposes'][$purpose]['name']);
            } else {
                $legitimateInterestPurposes[] = e('Unknown Purpose');
            }
        }
        if (count($legitimateInterestPurposes) === 0) {
            $legitimateInterestPurposes[] = 'None';
        }
        
        $features = [];
        foreach ($vendor['featureIds'] as $feature) {
            if (isset($rawVendorList['features'][$feature])) {
                $features[] = e($rawVendorList['features'][$feature]['name']);
            } else {
                $features[] = e('Unknown Feature');
            }
        }
        if (count($features) === 0) {
            $features[] = 'None';
        }

        $vendorList[] = [
            'id' => $vendor['id'],
            'name' => $vendor['name'],
            'privacy' => $vendor['policyUrl'],
            'purposes' => $purposes,
            'legintpurposes' => $legitimateInterestPurposes,
            'features' => $features,
        ];
    }

    $sort = $request->query('sort');
    $rev = $request->query('rev');

    if ($sort !== 'name') {
        $sort = 'id';
    }

    usort($vendorList, function($a, $b) use ($sort, $rev) {
        $a = $a[$sort];
        $b = $b[$sort];
        
        if ($sort === 'name') {
            $a = strtolower($a);
            $b = strtolower($b);
        }

        if ($a === $b) {
            return 0;
        } else if ($rev === '1') {
            return ($a > $b) ? -1 : 1;
        } else {
            return ($a < $b) ? -1 : 1;
        }
    });
    
    return view('vendorlist', [
        'vendorlist' => $vendorList,
        'version' => $rawVendorList['vendorListVersion'],
        'lastupdated' => (new Carbon($rawVendorList['lastUpdated']))->toRfc7231String(),
    ]);
});
