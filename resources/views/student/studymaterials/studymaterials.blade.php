@include('layouts.s_header')
@include('layouts.s_sidebar')


<main class="app-main">
    <!-- App Content Header -->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Study Materials</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Student</a></li>
                        <li class="breadcrumb-item active">Study Materials</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- App Content -->
    <div class="app-content">
        <div class="container-fluid">
            <!-- Courses List -->
            <div class="card">
                <div class="card-header py-2">
                    <h3 class="card-title">Study Materials</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Courses Table -->
                        <div class="col-12">
                            <table class="table table-bordered" id="courses-table" width="100%">
                                <thead>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Title</th>
                                        <th>Attachment</th>
                                        <th>Class</th>
                                        <th>Subject</th>
                                        <th>Date</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($studymaterials as $studymaterial)
                                        <tr>
                                            <td>{{ $studymaterial->id }}</td>
                                            <td>{{ $studymaterial->title }}</td>
                                            <td>
                                                @if ($studymaterial->attachment)
                                                    @php
                                                        $fileExtension = pathinfo($studymaterial->attachment, PATHINFO_EXTENSION);
                                                    @endphp
                                                    
                                                    @if (in_array($fileExtension, ['jpg', 'jpeg', 'png']))
                                                        <img src="{{ asset('storage/' . $studymaterial->attachment) }}" height="80" alt="Attachment">
                                                    @elseif (in_array($fileExtension, ['pdf']))
                                                        <a href="{{ asset('storage/' . $studymaterial->attachment) }}" target="_blank">
                                                            <i class="fa fa-file-pdf text-danger"></i> View PDF
                                                        </a>
                                                    @elseif (in_array($fileExtension, ['doc', 'docx']))
                                                        <a href="{{ asset('storage/' . $studymaterial->attachment) }}" target="_blank">
                                                            <i class="fa fa-file-word text-primary"></i> View Document
                                                        </a>
                                                    @elseif (in_array($fileExtension, ['ppt', 'pptx']))
                                                        <a href="{{ asset('storage/' . $studymaterial->attachment) }}" target="_blank">
                                                            <i class="fa fa-file-powerpoint text-warning"></i> View Presentation
                                                        </a>
                                                    @else
                                                        <a href="{{ asset('storage/' . $studymaterial->attachment) }}" target="_blank">
                                                            <i class="fa fa-file"></i> Download
                                                        </a>
                                                    @endif
                                                @else
                                                    No Attachment
                                                @endif
                                            </td>
                                            <td>
                                            @php
                                                $class = \App\Models\admin\ClassModel::find($studymaterial->classes);
                                                echo $class ? $class->title : 'No Class';
                                            @endphp
                                            </td>
                                            <td>
                                            @php
                                                $subjectNames = [];
                                                foreach (explode(',', $studymaterial->subjects) as $subjectId) {
                                                    $subject = \App\Models\admin\SubjectModel::find($subjectId);
                                                    if ($subject) {
                                                        $subjectNames[] = $subject->name;
                                                    }
                                                }
                                                echo implode(', ', $subjectNames);
                                            @endphp
                                            </td>
                                            <td>{{ $studymaterial->date }}</td>
                                            <td>{{ $studymaterial->description }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


@include('layouts.a_footer')
