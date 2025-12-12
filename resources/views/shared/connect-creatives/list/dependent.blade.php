@section('styles')
    @include('components.styles-DataTable')

    <style>
        .requester_name {
            width: 100%;
            font-weight: bold;
        }

        .requester_type {
            padding: 5px 8px;
            border-radius: 15px;

            font-size: 12px;
            font-weight: bold;
            color: #FFF;
        }

        .requester_type.Admin {
            background-color: #d26512ff;
        }

        .requester_type.Creative {
            background-color: #14bf8eff;
        }

        .requester_type.Member {
            background-color: #1385baff;
        }

        .requester_type.Guest {
            background-color: #8c8c8cff;
        }

    </style>
@endsection

@section('scripts-bottom')
    @include('components.scripts-DataTable')

    <script>
      $(function () {
          $('#table-connect-with-creatives').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "responsive": true,
          "order": []
          });
      });

      
    </script>
@endsection