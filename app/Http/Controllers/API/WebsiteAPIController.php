<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateWebsiteAPIRequest;
use App\Http\Requests\API\UpdateWebsiteAPIRequest;
use App\Models\Website;
use App\Repositories\WebsiteRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\WebsiteResource;
use Response;

/**
 * Class WebsiteController
 * @package App\Http\Controllers\API
 */

class WebsiteAPIController extends AppBaseController
{
    /** @var  WebsiteRepository */
    private $websiteRepository;

    public function __construct(WebsiteRepository $websiteRepo)
    {
        $this->websiteRepository = $websiteRepo;
    }

    /**
     * Display a listing of the Website.
     * GET|HEAD /websites
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {

        $websites = $this->websiteRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(WebsiteResource::collection($websites), 'Websites retrieved successfully');
    }

    /**
     * Store a newly created Website in storage.
     * POST /websites
     *
     * @param CreateWebsiteAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateWebsiteAPIRequest $request)
    {
        $input = $request->all();

        $website = $this->websiteRepository->create($input);

        return $this->sendResponse(new WebsiteResource($website), 'Website saved successfully');
    }

    /**
     * Display the specified Website.
     * GET|HEAD /websites/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Website $website */
        $website = $this->websiteRepository->find($id);

        if (empty($website)) {
            return $this->sendError('Website not found');
        }

        return $this->sendResponse(new WebsiteResource($website), 'Website retrieved successfully');
    }

    /**
     * Update the specified Website in storage.
     * PUT/PATCH /websites/{id}
     *
     * @param int $id
     * @param UpdateWebsiteAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateWebsiteAPIRequest $request)
    {
        $input = $request->all();

        /** @var Website $website */
        $website = $this->websiteRepository->find($id);

        if (empty($website)) {
            return $this->sendError('Website not found');
        }

        $website = $this->websiteRepository->update($input, $id);

        return $this->sendResponse(new WebsiteResource($website), 'Website updated successfully');
    }

    /**
     * Remove the specified Website from storage.
     * DELETE /websites/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Website $website */
        $website = $this->websiteRepository->find($id);

        if (empty($website)) {
            return $this->sendError('Website not found');
        }

        $website->delete();

        return $this->sendSuccess('Website deleted successfully');
    }
}
