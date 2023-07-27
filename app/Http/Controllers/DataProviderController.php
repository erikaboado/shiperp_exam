<?php

namespace App\Http\Controllers;

use App\Models\DataProvider;
use App\Http\Requests\CreateDataProviderRequest;
use App\Http\Requests\UpdateDataProviderRequest;

class DataProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataProviders = DataProvider::get();
        return response()->json(['data_providers' => $dataProviders]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateDataProviderRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateDataProviderRequest $request)
    {
        $dataProvider = new DataProvider();
        $dataProvider->name = $request->name;
        $dataProvider->url = $request->url;
        $dataProvider->save();

        return response()->json(['status' => "success"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dataProvider = DataProvider::find($id);
        return response()->json(['data_provider' => $dataProvider]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateDataProviderRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDataProviderRequest $request, $id)
    {
        $dataProvider = DataProvider::find($id);
        $dataProvider->name = $request->name;
        $dataProvider->url = $request->url;
        $dataProvider->save();

        return response()->json(['status' => "success"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DataProvider::destroy($id);
        return response()->json(['status' => "success"]);
    }
}
