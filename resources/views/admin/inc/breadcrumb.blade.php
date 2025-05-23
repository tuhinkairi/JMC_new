    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="#">
                        @can('isAdmin')
                            Admin
                        @endcan
                        @can('isReviewer')
                            Reviewer
                        @endcan
                        @can('isAuthor')
                            Author
                        @endcan
                        @can('isStaff')
                            Staff
                        @endcan
                        </a></li>
                        <li class="breadcrumb-item active">{{ $title }}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ $title }}</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
