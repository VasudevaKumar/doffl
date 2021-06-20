@extends('layouts.sass-app')
@section('content')

    <!-- START Saas Features -->
    <section class="border-bottom bg-white sp-100 pb-3 overflow-hidden">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="sec-title mb-60">
                        <h3>{{ $frontDetail->task_management_title }}</h3>
                        <p>{{ $frontDetail->task_management_detail }}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                @forelse($featureTasks as $featureTask)
                    <div class="col-md-4 col-sm-6 col-12 mb-60">
                        <div class="saas-f-box">
                            <div class="align-items-center icon justify-content-center">
                                <i class="{{ $featureTask->icon }}"></i>
                            </div>
                            <h5>{{ $featureTask->title }}</h5>
                            <p class="mb-0">{!!  $featureTask->description !!} </p>
                        </div>
                    </div>
                @empty
                @endforelse
            </div>
        </div>
    </section>

@endsection
@push('footer-script')

@endpush
