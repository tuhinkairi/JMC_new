@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <!-- Include page breadcrumb -->
    @include('admin.inc.breadcrumb')
    <div class="table-responsive">
        <table id="basic-datatable" class="table table-striped table-hover table-white nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Subject</th>
                    <th>Date Created</th>
                    <th>Date Published</th>
                    <th>Stage</th>
                </tr>
            </thead>
            <tbody>
               @foreach ($acceptances as $acceptance )
                <tr>
                    <td><a href="{{url('dashboard/author/article/show/'.$acceptance->article_id)}}">{{$acceptance->journal_short_form}}-0000{{$acceptance->article_id }}</td>
                    <td>{{$acceptance->scheduled_to}}</td>
                    <td>{{$acceptance->accepted_on}}</td>
                    <td>{{$acceptance->published_on}}</td>
                    <td>
                        @if($acceptance->status == 'Draft')
                        <span class="badge badge-pill" style="background-color:#a3a375; color:#ffffff;border:1px solid #a3a375">Draft</span>
                        @elseif ($acceptance->status == 'Accepted')
                        <span class="badge badge-pill" style="background-color:#33cc33; color:#ffffff;border:1px solid #33cc33">Accepted</span>
                        @else
                        <span class="badge badge-pill" style="background-color:#ff0000; color:#ffffff;border:1px solid #ff0000">Declined</span>
                        @endif
                        </td>
                </tr>
               @endforeach
            </tbody>
        </table>
</div>
</div>
@endsection
