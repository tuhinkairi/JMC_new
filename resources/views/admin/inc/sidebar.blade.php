<!--- Sidemenu -->
<div id="sidebar-menu">

    <ul class="metismenu" id="side-menu">

        <li class="menu-title"></li>

        @can('isAdmin')
        <li style="list-style: none">
            @if (isset($journalss))
            <div class="form-group">
                <select class="form-control" name="journal" id="journal" required>
                    <option value="0">Select Journal</option>
                    @foreach ($journalss as $journal)
                        <option value="{{$journal->id}}">{{$journal->short_form}}</option>
                    @endforeach
                </select>
            </div>
            @endif
        </li>
        @endcan

        <li>
            <a href="{{ URL::route('dashboard.index') }}">
                <span class="icon"><i class="fas fa-desktop"></i></span>
                <span> Dashboard </span>
            </a>
        </li>

        @can('isAdmin')
        {{-- <li>
            <a href="javascript: void(0);">
                <span class="icon"><i class="fas fa-newspaper"></i></span>
                <span> Articles </span>
                <span class="menu-arrow"></span>
            </a>
            <ul class="nav-second-level" aria-expanded="false">
                <li>
                    <a href="{{ URL::route('article.approve') }}">Approve List</a>
                    <a href="{{ URL::route('article.pending') }}">Pending List</a>
                    <a href="{{ URL::route('article.reject') }}">Reject List</a>
                </li>
            </ul>
        </li> --}}
        <li>
            <a href="javascript: void(0);">
                <span class="icon"><i class="fas fa-newspaper"></i></span>
                <span> Submissions </span>
                <span class="menu-arrow"></span>
            </a>
            <ul class="nav-second-level" aria-expanded="false">
                <li>
                    <a href="{{ URL::route('new.submission') }}">Submission List</a>
                    <a href="{{ URL::route('create.new.submission') }}">Make New Submissions</a>
                </li>
            </ul>
        </li>

        <li>
            <a href="{{ URL::route('article-category.index') }}">
                <span class="icon"><i class="fas fa-align-justify"></i></span>
                <span> Research Area </span>
            </a>
        </li>

        {{-- <li>
            <a href="{{ URL::route('comment.index') }}">
                <span class="icon"><i class="fas fa-comments"></i></span>
                <span> Comments </span>
            </a>
        </li>

        <li>
            <a href="{{ URL::route('requirement.index') }}">
                <span class="icon"><i class="fas fa-chalkboard-teacher"></i></span>
                <span> Requirements </span>
            </a>
        </li> --}}

        <li>
            <a href="{{ URL::route('reviewer.index') }}">
                <span class="icon"><i class="fas fa-user-tag"></i></span>
                <span> Reviewers </span>
            </a>
        </li>

        <li>
            <a href="{{ URL::route('author.index') }}">
                <span class="icon"><i class="fas fa-user-edit"></i></span>
                <span>Authors </span>
            </a>
        </li>

        <li>
            <a href="{{ URL::route('payment.index') }}">
                <span class="icon"><i class="fas fa-user-edit"></i></span>
                <span>Payment Rate</span>
            </a>
        </li>

        <li>
            <a href="{{ URL::route('new.staff') }}">
                <span class="icon"><i class="fas fa-user"></i></span>
                <span> Staff </span>
            </a>
        </li>

        <li>
            <a href="{{ URL::route('profile.index') }}">
                <span class="icon"><i class="fas fa-users-cog"></i></span>
                <span> Profile </span>
            </a>
        </li>



        <li>
            <a href="{{ URL::route('setting.index') }}">
                <span class="icon"><i class="fas fa-cog"></i></span>
                <span> Settings </span>
            </a>
        </li>

        @endcan


        @can('isReviewer')
        {{-- <li>
            <a href="javascript: void(0);">
                <span class="icon"><i class="fas fa-newspaper"></i></span>
                <span> Articles </span>
                <span class="menu-arrow"></span>
            </a>
            <ul class="nav-second-level" aria-expanded="false">
                <li>
                    <a href="{{ URL::route('reviewer.article.approve') }}">Approve List</a>
                    <a href="{{ URL::route('reviewer.article.reject') }}">Reject List</a>
                </li>
            </ul>
        </li> --}}



        <li>
            <a href="{{ URL::route('reviewer.profile.index') }}">
                <span class="icon"><i class="fas fa-users-cog"></i></span>
                <span> Profile </span>
            </a>
        </li>
        @endcan


        @can('isAuthor')
        {{-- <li>
            <a href="{{ URL::route('author.article.index') }}">
                <span class="icon"><i class="fas fa-newspaper"></i></span>
                <span> Articles </span>
            </a>
        </li> --}}

        {{-- <li>
            <a href="{{ URL::route('author.issue.index') }}">
                <span class="icon"><i class="fas fa-question-circle"></i></span>
                <span> Issues </span>
            </a>
        </li> --}}

        <li>
            <a href="javascript: void(0);">
                <span class="icon"><i class="fas fa-newspaper"></i></span>
                <span> Submissions </span>
                <span class="menu-arrow"></span>
            </a>
            <ul class="nav-second-level" aria-expanded="false">
                <li>
                    <a href="{{url('dashboard/author/addarticle')}}">Make New Submissions</a>
                    <a href="{{ URL::route('author.article.index') }}">Submissions List</a>
                
                </li>
            </ul>
        </li>



        <li>
            <a href="{{url('dashboard/author/copyright_acceptance')}}">
                <span class="icon"><i class="fas fa-check-circle"></i></span>
                <span> Acceptances</span>
            </a>
        </li>

        <li>
            <a href="{{url('dashboard/author/downloads')}}">
                <span class="icon"><i class="fas fa-download"></i></span>
                <span> Useful Downloads </span>
            </a>
        </li>

        <li>
            <a href="{{url('dashboard/author/knowledgebase')}}">
                <span class="icon"><i class="fas fa-file-video"></i></span>
                <span> Guideline Videos </span>
            </a>
        </li>

        <li>
            <a href="{{url('dashboard/author/faq')}}">
                <span class="icon"><i class="fas fa-file"></i></span>
                <span> FAQs </span>
            </a>
        </li>

        <li>
            <a href="{{ URL::route('author.profile.index') }}">
                <span class="icon"><i class="fas fa-users-cog"></i></span>
                <span> Profile </span>
            </a>
        </li>


        @endcan


        @can('isStaff')
        {{-- <li>
            <a href="{{ URL::route('author.article.index') }}">
                <span class="icon"><i class="fas fa-newspaper"></i></span>
                <span> Articles </span>
            </a>
        </li> --}}

        <li>
            <a href="{{ URL::route('staff.task.index') }}">
                <span class="icon"><i class="fas fa-question-circle"></i></span>
                <span> Tasks </span>
            </a>
        </li>

        <li>
            <a href="{{ URL::route('staff.profile.index') }}">
                <span class="icon"><i class="fas fa-users-cog"></i></span>
                <span> Profile </span>
            </a>
        </li>
        @endcan


    </ul>

</div>
<!-- End Sidebar -->
