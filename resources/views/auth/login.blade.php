@extends('layouts.login-layout')
@section('title', 'Login Page')
@section('content')
    {{-- <style>
        #particles-js {
            position: relative;
            /* background-color: g */
            min-height: 100vh;

        }

        #particles-js>div {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style> --}}
    <div class="content-wrapper" style="
    background-image: url({{ asset('wave.png') }});
    background-repeat:no-repeat;
    background-size:cover;
    ">
        {{-- <div class="content-body " id="particles-js"> --}}
            <div class="" style="width: 100%">
                <div class="">
                    <div id="login-container"></div>
                </div>
            </div>
            </div>
    {{-- TODO: Remove Poter .js --}}
    <!-- stats.js -->
    <script>
        window.lang = { ar:'' , en:''}
        window.lang.en = @json(__('en/translation', [] , '/'));
        window.lang.ar = @json(__('ar/translation', [] , '/'));
    </script>
    {{-- <script src="{{ asset('practiels/js/lib/stats.js') }}"></script> --}}

    <script src="{{ mix('js/app.js') }}"></script>
    {{-- <script>
        var count_particles, stats, update;
        stats = new Stats;
        stats.setMode(0);
        stats.domElement.style.position = 'absolute';
        stats.domElement.style.left = '0px';
        stats.domElement.style.top = '0px';
        document.body.appendChild(stats.domElement);
        count_particles = document.querySelector('.js-count-particles');
        update = function() {
            stats.begin();
            stats.end();
            if (window.pJSDom[0].pJS.particles && window.pJSDom[0].pJS.particles.array) {
                // count_particles.innerText = window.pJSDom[0].pJS.particles.array.length;
            }
            requestAnimationFrame(update);
        };
        requestAnimationFrame(update);
        document.getElementById('fps').style.display = 'none';
    </script> --}}

@endsection
