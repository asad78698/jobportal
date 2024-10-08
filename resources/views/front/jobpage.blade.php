@extends('front.layouts.app')

@section('main')

    <section class="section-3 py-5 bg-2 ">
        <div class="container">
            <div class="row">
                <div class="col-6 col-md-10 ">
                    <h2>Find Jobs</h2>
                </div>
                <div class="col-6 col-md-2">
                    <div class="align-end">
                        <select name="sort" id="sort" class="form-control">
                            <option {{(Request::get('sort')==1)?'selected':''}} value="1">Latest</option>
                            <option {{(Request::get('sort')=="asc")?'selected':''}} value="asc">Oldest</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row pt-5">
                <div class="col-md-4 col-lg-3 sidebar mb-4">
                    <form action="" name="searchform" id="searchform">
                        <div class="card border-0 shadow p-4">
                            <div class="mb-4">
                                <h2>Keywords</h2>
                                <input value="{{ Request::get('keyword') }}" id="keyword" name="keyword" type="text"
                                    placeholder="Keywords" class="form-control">
                            </div>

                            <div class="mb-4">
                                <h2>Location</h2>
                                <input value="{{ Request::get('location') }}" id="location" name="location" type="text"
                                    placeholder="Location" class="form-control">
                            </div>


                            <div class="mb-4">
                                <h2>Category</h2>
                                <select name="category" id="category" class="form-control">
                                    <option>Select a Category</option>
                                    @if ($categories)
                                        @foreach ($categories as $category)
                                            <option {{ Request::get('category') == $category->id ? 'selected' : '' }}
                                                value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="mb-4">
                                <h2>Job Type</h2>
                                @if ($jobtypes->isNotEmpty())
                                    @foreach ($jobtypes as $jobtype)
                                        <div class="form-check mb-2">
                                            <input {{(in_array($jobtype->id, $jobTypeArray))? 'checked' : ''}}  class="form-check-input " name="jobtype" type="checkbox"
                                                value="{{ $jobtype->id }}" id="jobtype">
                                            <label class="form-check-label ">{{ $jobtype->name }}</label>
                                        </div>
                                    @endforeach
                                @endif

                            </div>

                            <div class="mb-4">
                                <h2>Experience</h2>
                                <select name="experience" id="experience" class="form-control">
                                    <option value="">Select Experience</option>
                                    <option value="1"{{ Request::get('experience') == 1 ? 'selected' : '' }}>1 Year
                                    </option>
                                    <option value="2"{{ Request::get('experience') == 2 ? 'selected' : '' }}>2 Years
                                    </option>
                                    <option value="3"{{ Request::get('experience') == 3 ? 'selected' : '' }}>3 Years
                                    </option>
                                    <option value="4"{{ Request::get('experience') == 4 ? 'selected' : '' }}>4 Years
                                    </option>
                                    <option value="5"{{ Request::get('experience') == 5 ? 'selected' : '' }}>5 Years
                                    </option>
                                    <option value="6"{{ Request::get('experience') == 6 ? 'selected' : '' }}>6 Years
                                    </option>
                                    <option value="7"{{ Request::get('experience') == 7 ? 'selected' : '' }}>7 Years
                                    </option>
                                    <option value="8"{{ Request::get('experience') == 8 ? 'selected' : '' }}>8 Years
                                    </option>
                                    <option value="9"{{ Request::get('experience') == 9 ? 'selected' : '' }}>9 Years
                                    </option>
                                    <option value="10">10 Years</option>
                                    <option value="{{ '10+' }}">10+ Years</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Search</button>


                        </div>
                        

                    </form>
                    <center class="mt-2">
                    <a href="{{ route('jobs') }}" class="btn btn-primary w-100">Reset</a>
                </center>
                 </div>
                <div class="col-md-8 col-lg-9 ">
                    <div class="job_listing_area">
                        <div class="job_lists">
                            <div class="row">
                                @if ($jobs->isNotEmpty())
                                    @foreach ($jobs as $job)
                                        <div class="col-md-4">
                                            <div class="card border-0 p-3 shadow mb-4">
                                                <div class="card-body">
                                                    <h3 class="border-0 fs-5 pb-2 mb-0">{{ $job->title }}</h3>
                                                    <p>{{ Str::words($job->description, 4) }}</p>
                                                    <div class="bg-light p-3 border">
                                                        <p class="mb-0">
                                                            <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                                                            <span class="ps-1">{{ $job->location }}</span>
                                                        </p>
                                                        <p class="mb-0">
                                                            <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                                            <span class="ps-1">{{ $job->jobType->name }}</span>
                                                        </p>
                                                        @if (!is_null($job->salary))
                                                            <p class="mb-0">
                                                                <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                                                                <span class="ps-1">{{ $job->salary }}</span>
                                                            </p>
                                                        @endif
                                                    </div>

                                                    <div class="d-grid mt-3">
                                                        <a href="{{route('job.details', $job->id)}}" class="btn btn-primary btn-lg">Details</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-md-12">
                                        <div class="alert alert-danger">No Jobs Found</div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection

@section('searchJobFilter')
<script>
    $(document).ready(function() {
        $('#searchform').submit(function(e) {
            e.preventDefault();

            var url = '{{ route('jobs') }}?';

            var keyword = $('#keyword').val();
            var location = $('#location').val();
            var category = $('#category').val();
            var experience = $('#experience').val();
            var jobtype = $('#jobtype').val();
            var sort = $('#sort').val();

            var checkedJobs = $('input:checkbox[name="jobtype"]:checked').map(function() {
                return $(this).val();
            }).get();
            
            if (keyword !== '') {
                url += '&keyword=' + keyword;
            }

            if (location !== '') {
                url += '&location=' + location;
            }

            if (category !== '' && category !== 'Select a Category') {
                url += '&category=' + category;
            }

            if (checkedJobs.length > 0) {
                url += '&jobtype=' + checkedJobs.join(',');
            }

            if (experience !== '') {
                url += '&experience=' + experience;
            }
             
            url += '&sort=' + sort;

            window.location.href = url;
        });

        $('#sort').change(function() {
            $('#searchform').submit();
        });
    });

</script>

@endsection
