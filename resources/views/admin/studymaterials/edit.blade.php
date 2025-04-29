@include('layouts.a_header')
@include('layouts.a_sidebar')

<style>
    .form-group {
        position: relative; /* Make sure form-group is relatively positioned to position the counter */
    }

    .form-control {
        padding-right: 50px; /* Leaves space for the counter */
    }

    .char-counter {
        position: absolute;
        right: 10px; /* Shift the counter to the right */
        top: 81%; /* Vertically align the counter */
        transform: translateY(-50%); /* Ensure the counter is perfectly centered vertically */
        font-size: 13px;
        color: gray;
        background: transparent;
        padding: 10px;
        pointer-events: none;
    }

    /* New styles for legend */
    fieldset {
        position: relative;
        border-top: 2px solid #000; /* Horizontal line */
        margin-top: 20px;
        padding-top: 20px;
    }

    legend {
        position: absolute;
        top: -10px; /* Adjusts vertical alignment */
        left: 10px; /* Adjusts horizontal alignment */
        background: #fff; /* Cuts through the horizontal line */
        padding: 0 10px; /* Adds spacing around text */
        font-size: 14px; /* Adjust font size */
        color: #000; /* Adjust text color */
    }
</style> 

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="mb-0">Edit Study-Materials</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <form action="{{ route('admin.studymaterials.update', ['id' => $studymaterials->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" value="{{ isset($studymaterials) ? $studymaterials->title : '' }}" class="form-control" id="title" maxlength="50" style="margin-top: 20px;" placeholder="Title" required oninput="updateCounter('title', 'titleCounter')">
                            <span id="titleCounter" class="char-counter">0/50</span>
                        </div>
                        <div class="form-group">
                            <label for="description" style="margin-top: 20px;">Description</label>
                            <textarea name="description" id="description" maxlength="150" required oninput="updateCounter('description', 'descriptionCounter')" class="form-control" style="margin-top: 20px;">{{ isset($studymaterials) ? $studymaterials->description : '' }}</textarea>
                            <span id="descriptionCounter" class="char-counter">0/150</span>
                        </div>
                        <div class="form-group">
                            <label for="attachment" style="margin-top: 20px;">Attachment</label>
                            <div class="row" style="margin-top: 20px;">
                                <div class="col-md-6">
                                    <input type="file" name="attachment" id="attachment" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    @if(isset($studymaterials->attachment))
                                        <a href="{{ asset('storage/' . $studymaterials->attachment) }}" target="_blank" class="btn btn-primary">
                                            View Current Attachment
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="classes" style="margin-top: 20px;">Class</label>
                            <select name="classes" id="classes" class="form-control" style="margin-top: 20px;" required>
                                <option value="">Select Class</option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}" {{ isset($studymaterials) && $studymaterials->classes == $class->id ? 'selected' : '' }}>{{ $class->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="subjects" style="margin-top: 20px;">Subject</label>
                            <select name="subjects" id="subjects" class="form-control" style="margin-top: 20px;" required>
                                <option value="">Select Subject</option>
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ isset($studymaterials) && $studymaterials->subjects == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="date" style="margin-top: 20px;">Date</label>
                            <input type="date" name="date" value="{{ isset($studymaterials) ? $studymaterials->date : '' }}" id="date" style="margin-top: 20px; padding-right: 10px;" required class="form-control" min="{{ date('Y-m-d') }}">
                        </div>
                        <!-- Submit Button -->
                        <button type="submit" id="submitBtn" class="btn btn-success" style="margin-top: 20px;">
                        Update
                        </button>
                        <a href="{{ route('admin.studymaterials') }}" class="btn btn-danger" style="margin-top: 20px;">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Script for updating counters -->
<script>
    function updateCounter(inputId, counterId) {
        let inputElement = document.getElementById(inputId);
        let counterElement = document.getElementById(counterId);
        counterElement.textContent = `${inputElement.value.length}/${inputElement.maxLength}`;
    }
</script>

@include('layouts.a_footer')
