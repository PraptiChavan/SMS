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
                    <h3 class="mb-0">Edit Exam-Schedule</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <form action="{{ route('admin.examform.update', ['id' => $examform->id]) }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" value="{{ isset($examform) ? $examform->name : '' }}" class="form-control" id="name" maxlength="50" style="margin-top: 20px;" placeholder="Name" required oninput="updateCounter('name', 'nameCounter')">
                            <span id="nameCounter" class="char-counter">0/50</span>
                        </div>
                        <div class="form-group">
                            <label for="classes" style="margin-top: 20px;">Class</label>
                            <select name="classes" id="classes" class="form-control" style="margin-top: 20px;" required>
                                <option value="">Select Class</option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}" {{ isset($examform) && $examform->classes == $class->id ? 'selected' : '' }}>{{ $class->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="subjects" style="margin-top: 20px;">Subject</label>
                            <select name="subjects" id="subjects" class="form-control" style="margin-top: 20px;" required>
                                <option value="">Select Subject</option>
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ isset($examform) && $examform->subjects == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="date" style="margin-top: 20px;">Date</label>
                            <input type="date" name="date" value="{{ isset($examform) ? $examform->date : '' }}" id="date" style="margin-top: 20px; padding-right: 10px;" required class="form-control" min="{{ date('Y-m-d') }}">
                        </div>
                        <div class="form-group">
                            <label for="start_time" style="margin-top: 20px;">Start Time</label>
                            <input type="time" id="start_time" value="{{ isset($examform) ? $examform->start_time : '' }}" name="start_time" style="margin-top: 20px; margin-bottom: 20px; padding-right: 10px;" placeholder="Start Time" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="end_time">End Time</label>
                            <input type="time" id="end_time" value="{{ isset($examform) ? $examform->end_time : '' }}" name="end_time" style="margin-top: 20px; padding-right: 10px;" placeholder="End Time" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="total_marks" style="margin-top: 20px;">Total Marks</label>
                            <input type="number" value="{{ isset($examform) ? $examform->total_marks : '' }}" style="margin-top: 20px; padding-right: 10px;" class="form-control" placeholder="Total Marks" name="total_marks" id="total_marks" required>
                        </div>
                        <!-- Submit Button -->
                        <button type="submit" id="submitBtn" class="btn btn-success" style="margin-top: 20px;">
                        Update
                        </button>
                        <a href="{{ route('admin.examform') }}" class="btn btn-danger" style="margin-top: 20px;">Cancel</a>
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
