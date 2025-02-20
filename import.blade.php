<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Replies</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Import Replies</h2>

        <!-- Download Sample -->
        <a href="{{ url('/download-sample') }}" class="btn btn-success mb-3">Download Sample Excel</a>

        <!-- Upload Form -->
        <form action="{{ url('/import-replies') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="file" class="form-label">Upload Excel File</label>
                <input type="file" name="file" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Import</button>
        </form>

        <!-- Export Existing Data -->
        <hr>
        <h3 class="mt-4">Export Existing Replies</h3>
        <a href="{{ url('/export-existing-replies') }}" class="btn btn-warning">Download Existing Data</a>
    </div>
</body>
</html>
