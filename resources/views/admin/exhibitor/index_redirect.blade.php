<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Redirecting...</title>
</head>
<body>
    <form id="postForm" action="{{ route('admin.exhibitors.list') }}" method="POST">
        @csrf
    </form>
    <script type="text/javascript">
        document.getElementById('postForm').submit();
    </script>
</body>
</html>