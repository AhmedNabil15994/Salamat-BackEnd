<?php

namespace Modules\Offer\Http\Controllers\Clinic;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Offer\Http\Requests\Clinic\OfferRequest;
use Modules\Offer\Transformers\Clinic\OfferResource;
use Modules\Offer\Repositories\Clinic\OfferRepository as Offer;

class OfferController extends Controller
{

    function __construct(Offer $offer)
    {
        $this->offer = $offer;
    }

    public function index()
    {
        return view('offer::clinic.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->offer->QueryTable($request));

        $datatable['data'] = OfferResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function create()
    {
        return view('offer::clinic.create');
    }

    public function store(OfferRequest $request)
    {
        try {
            $create = $this->offer->create($request);

            if ($create) {
                return Response()->json([true , __('apps::clinic.messages.created')]);
            }

            return Response()->json([true , __('apps::clinic.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function show($id)
    {
        return view('offer::clinic.show');
    }

    public function edit($id)
    {
        $offer = $this->offer->findById($id);

        return view('offer::clinic.edit',compact('offer'));
    }

    public function update(OfferRequest $request, $id)
    {
        try {
            $update = $this->offer->update($request,$id);

            if ($update) {
                return Response()->json([true , __('apps::clinic.messages.updated')]);
            }

            return Response()->json([true , __('apps::clinic.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function destroy($id)
    {
        try {
            $delete = $this->offer->delete($id);

            if ($delete) {
              return Response()->json([true , __('apps::clinic.messages.deleted')]);
            }

            return Response()->json([true , __('apps::clinic.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function deletes(Request $request)
    {
        try {
            $deleteSelected = $this->offer->deleteSelected($request);

            if ($deleteSelected) {
              return Response()->json([true , __('apps::clinic.messages.deleted')]);
            }

            return Response()->json([true , __('apps::clinic.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
