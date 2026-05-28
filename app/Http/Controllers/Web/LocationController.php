// app/Http/Controllers/Web/LocationController.php
<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\UpdateLocationRequest;
use App\Repositories\LocationRepository;
use App\Repositories\CompanyRepository;
use App\Services\LocationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LocationController extends Controller
{
    public function __construct(
        private readonly LocationService $locationService,
        private readonly LocationRepository $locationRepository,
        private readonly CompanyRepository $companyRepository
    ) {}

    public function index(Request $request): View
    {
        $locations = $this->locationService->getLocationsForUser($request->user());

        return view('locations.index', compact('locations'));
    }

    public function create(): View
    {
        return view('locations.create');
    }

    public function store(StoreLocationRequest $request): RedirectResponse
    {
        $this->locationService->store($request->validated(), $request->user());

        return redirect()->route('locations.index')->with('success', '拠点を登録しました。');
    }

    public function edit(string $locationId): View
    {
        $location = $this->locationRepository->findById($locationId);
        abort_if(!$location, 404);

        return view('locations.edit', compact('location'));
    }

    public function update(UpdateLocationRequest $request, string $locationId): RedirectResponse
    {
        $this->locationService->update($locationId, $request->validated(), $request->user());

        return redirect()->route('locations.index')->with('success', '拠点情報を更新しました。');
    }
}