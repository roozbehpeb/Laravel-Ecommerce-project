@if(session('toast-info'))

    <section class="toast" data-delay="5000">

        <section class="toast-body py-3 d-flex bg-info text-white">
            <strong class="ml-auto">{{ session('toast-info') }}</strong>
            <button type="button" class="mr-2 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
        </section>
    </section>

    <script>
        $(document).ready(function () {
            $('.toast').toast('show');
        })
    </script>


@endif
