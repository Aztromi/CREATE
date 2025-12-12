 @extends('layouts.app')

@section('styles')
<style>
    #accordion{
        color: #000000;
    }
</style>
@endsection

@section('scripts-bottom')
<script src="{{ asset('js/registration/registration_step03.js?ver='.time()) }}"></script>

@endsection

@section('content')

<div class="bg_black25 registration-fields">
    <div class="container-fluid login-container">
        <div class="row">

            @include('components.half_pane_works')
            
            <div class="col-xs-12 col-lg-6">
                <section>
                    <h1>
                        Sectors of interest...
                    </h1>
                    <hr>
                    <form class="mt-60" id="frm-interests" method="POST" action="{{ route('user.register.step-three.validate') }}">
                    @csrf
                        <div class="row mb-30">
                            <h3>
                                Categories
                            </h3>
                        </div>
                        <div class="row mb-30">
                            <p class="error-message error-interests"></p>
                        </div>
                        <div class="row mb-30">


                            <div id="accordion">
                                @php $counter=1; @endphp
                                @foreach($sectorsData as $category => $values)
                                <div class="card card-primary">
                                    <div class="card-header">
                                    <h4 class="card-title w-100">
                                        <a class="d-block w-100" data-toggle="collapse" href="#collapse{{ $counter }}" style="text-decoration: none;">
                                        {{ $category }}
                                        </a>
                                    </h4>
                                    </div>
                                    <div id="collapse{{ $counter }}" class="collapse show" data-parent="#accordion">
                                    <div class="card-body">
                                        @foreach($values as $value)
                                        <div class="col-xs-12 col-sm-4 pb-20 multi-column-list">
                                            <div class="form-check">
                                                <!-- <input class="form-check-input" type="checkbox" value="{{ $category }}|745|{{ $value }}" id="int-{{ $value }}" name="interest[]"> -->
                                                <input class="form-check-input" type="checkbox" value="{{ $category }}|745|{{ $value }}" id="int-{{ $value }}" name="interest[]">
                                                <label class="form-check-label" for="int-{{ $value }}">
                                                    {{ $value }}
                                                </label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    </div>
                                </div>
                                @php $counter++; @endphp
                                @endforeach
                           
                            </div>

                            {{--
                            <!-- OTHER -->
                            <div class="col-xs-12 col-sm-4 pb-20">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="Other" id="int-other" name="interest[]">
                                    <label class="form-check-label" for="int-other">
                                        Other
                                    </label>
                                    <input type="text" name="otherInterest" id="otherInterest" placeholder="Other name...">
                                </div>
                            </div>
                            --}}

          
                        </div>
                        <hr>
                        <div class="row mb-30">
                            <div class="col">
                                <button class="btn btn-primary" type="submit">SAVE & CONTINUE</button>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
        
    </div>
</div>


@endsection