@extends('pages.admin.main')
@section('content')
    <div class="main-content-inner">
        <div class="row">
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Edit Buku</h4>
                        <form action="{{ route('adminBukuUpdate', $buku->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="judul">Judul</label>
                                <input type="text" class="form-control" id="judul" name="judul"
                                    value="{{ $buku->judul }}" required>
                            </div>
                            <div class="form-group">
                                <label for="author">Author</label>
                                <input type="text" class="form-control" id="author" name="author"
                                    value="{{ $buku->author }}">
                            </div>
                            <div class="form-group">
                                <label for="publisher">Publisher</label>
                                <input type="text" class="form-control" id="publisher" name="publisher"
                                    value="{{ $buku->publisher }}">
                            </div>
                            <div class="form-group">
                                <label for="year">Year</label>
                                <input type="number" class="form-control" id="year" name="year"
                                    value="{{ $buku->year }}" required>
                            </div>
                            <div class="form-group">
                                <label for="stock">Stock</label>
                                <input type="number" class="form-control" id="stock" name="stock"
                                    value="{{ $buku->stock }}" required>
                            </div>
                            <div class="form-group">
                                <label for="price_per_day">Price Per Day</label>
                                <input type="number" step="0.01" class="form-control" id="price_per_day"
                                    name="price_per_day" value="{{ $buku->price_per_day }}" required>
                            </div>
                            <div class="form-group">
                                <label for="max_days">Max Days</label>
                                <input type="number" class="form-control" id="max_days" name="max_days"
                                    value="{{ $buku->max_days }}">
                            </div>
                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required>{{ $buku->deskripsi }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input type="text" class="form-control" id="slug" name="slug"
                                    value="{{ $buku->slug }}" required>
                            </div>
                            <div class="form-group">
                                <label for="category_id">Category <button type="button" class="btn btn-sm btn-success"
                                        data-toggle="modal" data-target="#addCategoryModal">+</button></label>
                                <select class="form-control" id="category_id" name="category_id">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $buku->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="image">Image</label>
                                <input type="file" class="form-control" id="image" name="image">
                                @if ($buku->image)
                                    <img src="{{ asset('storage/' . $buku->image) }}" alt="{{ $buku->judul }}"
                                        style="width: 100px; height: auto; margin-top: 10px;">
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('adminBuku') }}" class="btn btn-secondary">Cancel</a>
                        </form>

                        <!-- Modal for adding category -->
                        <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog"
                            aria-labelledby="addCategoryModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="addCategoryForm">
                                            @csrf
                                            <div class="form-group">
                                                <label for="categoryName">Category Name</label>
                                                <input type="text" class="form-control" id="categoryName"
                                                    name="nama" required>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" id="saveCategory">Save
                                            Category</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('breadcrumbs')
    <div class="col-sm-6">
        <div class="breadcrumbs-area clearfix">
            <h4 class="page-title pull-left">Edit Buku</h4>
            <ul class="breadcrumbs pull-left">
                <li><a href="{{ route('adminDashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('adminBuku') }}">Buku</a></li>
            </ul>
        </div>
    </div>
@endsection
@section('header')
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/metisMenu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/slicknav.min.css') }}">
    <!-- amcharts css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css"
        media="all" />
    <!-- Start datatable css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
    <!-- style css -->
    <link rel="stylesheet" href="{{ asset('css/typography.css') }}">
    <link rel="stylesheet" href="{{ asset('css/default-css.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    <!-- modernizr css -->
    <script src="{{ asset('js/vendor/modernizr-2.8.3.min.js') }}"></script>
@endsection

@section('scripts')
    <script src="{{ asset('js/vendor/jquery-2.2.4.min.js') }}"></script>
    <!-- bootstrap 4 js -->
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('js/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('js/jquery.slicknav.min.js') }}"></script>

    <!-- Start datatable js -->
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
    <!-- others plugins -->
    <script src="{{ asset('js/plugins.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#saveCategory').on('click', function() {
                var categoryName = $('#categoryName').val();
                if (categoryName.trim() === '') {
                    alert('Category name is required.');
                    return;
                }

                $.ajax({
                    url: '{{ route('adminBukuCategoryStore') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        nama: categoryName
                    },
                    success: function(response) {
                        if (response.success) {
                            // Add new option to select
                            $('#category_id').append('<option value="' + response.category.id +
                                '">' + response.category.nama + '</option>');
                            // Select the new category
                            $('#category_id').val(response.category.id);
                            // Close modal
                            $('#addCategoryModal').modal('hide');
                            // Clear form
                            $('#categoryName').val('');
                        } else {
                            alert('Error adding category.');
                        }
                    },
                    error: function() {
                        alert('Error adding category.');
                    }
                });
            });
        });
    </script>
@endsection
