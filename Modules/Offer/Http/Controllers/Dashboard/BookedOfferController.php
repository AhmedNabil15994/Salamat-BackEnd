<?php

namespace Modules\Offer\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Offer\Transformers\Dashboard\BookedOfferResource;
use Modules\Offer\Repositories\Dashboard\BookedOfferRepository as BookedOffer;

class BookedOfferController extends Controller
{

    function __construct(BookedOffer $offer)
    {
        $this->offer = $offer;
    }

    public function index()
    {
        return view('offer::dashboard.orders.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->offer->QueryTable($request));

        $datatable['data'] = BookedOfferResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show($id)
    {
        $offer = $this->offer->findById($id);
        return view('offer::dashboard.orders.show',compact('offer'));
    }

    public function edit($id)
    {
    }

    public function update(OfferRequest $request, $id)
    {
    }

    public function destroy($id)
    {
        try {
            $delete = $this->offer->delete($id);

            if ($delete) {
              return Response()->json([true , __('apps::dashboard.messages.deleted')]);
            }

            return Response()->json([true , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function deletes(Request $request)
    {
        try {
            $deleteSelected = $this->offer->deleteSelected($request);

            if ($deleteSelected) {
              return Response()->json([true , __('apps::dashboard.messages.deleted')]);
            }

            return Response()->json([true , __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
