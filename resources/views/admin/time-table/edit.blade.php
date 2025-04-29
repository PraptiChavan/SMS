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
</style> 

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="mb-0">Edit Time-Table</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <form action="{{ route('admin.time-table.update', ['id' => $entry->id]) }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="classes" style="margin-top:10px"><b>Select Class</b></label>
                            <select name="req_classes" style="margin-top:20px" id="classes" class="form-control" required>
                                <option value="">Select Class</option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->title }}</option>
                                    @if(isset($classes) && $classes->isNotEmpty())
                                        @foreach ($classes as $class)
                                        <option value="{{ $class->id }}" 
                                            {{ isset($entry) && $entry->classes == $class->id ? 'selected' : '' }}>
                                            {{ $class->title }}
                                        </option>
                                        @endforeach
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="sections" style="margin-top:20px"><b>Select Section</b></label>
                            <select name="req_sections" style="margin-top:20px" id="sections" class="form-control" required>
                                <option value="">Select Section</option>
                                @if(isset($sections) && $sections->isNotEmpty())
                                    @foreach ($sections as $section)
                                    <option value="{{ $section->id }}" 
                                        {{ isset($entry) && in_array($section->id, explode(',', $entry->sections)) ? 'selected' : '' }}>
                                        {{ $section->title }}
                                    </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="teachers" style="margin-top:20px"><b>Select Teacher</b></label>
                            <select name="req_teachers" style="margin-top:20px" id="teachers" class="form-control" required>
                                <option value="">Select Teacher</option>
                                @if(isset($accounts) && $accounts->isNotEmpty())
                                    @foreach ($accounts as $account)
                                    <option value="{{ $account->id }}" 
                                        {{ isset($entry) && $entry->teachers == $account->id ? 'selected' : '' }}>
                                        {{ $account->name }}
                                    </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="periods" style="margin-top:20px"><b>Select Periods</b></label>
                            <select name="req_periods" style="margin-top:20px" id="periods" class="form-control" required>
                                <option value="">Select Periods</option>
                                @if(isset($periods) && $periods->isNotEmpty())
                                    @foreach ($periods as $period)
                                    <option value="{{ $period->id }}" 
                                        {{ isset($entry) && $entry->periods == $period->id ? 'selected' : '' }}>
                                        {{ $period->title }}
                                    </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="weekdays" style="margin-top:20px"><b>Select Weekdays</b></label>
                            <select name="req_weekdays" style="margin-top:20px" id="weekdays" class="form-control" required>
                                <option value="">Select Weekdays</option>
                                @if(isset($weekdays) && $weekdays->isNotEmpty())
                                    @foreach ($weekdays as $weekday)
                                    <option value="{{ $weekday->id }}" 
                                        {{ isset($entry) && $entry->weekdays == $weekday->id ? 'selected' : '' }}>
                                        {{ $weekday->title }}
                                    </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="subjects" style="margin-top:20px"><b>Select Subjects</b></label>
                            <select name="req_subjects" style="margin-top:20px" id="subjects" class="form-control" required>
                                <option value="">Select Subjects</option>
                                @if(isset($subjects) && $subjects->isNotEmpty())
                                    @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}" 
                                        {{ isset($entry) && $entry->subjects == $subject->id ? 'selected' : '' }}>
                                        {{ $subject->name }}
                                    </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <!-- Submit Button -->
                        <button type="submit" id="submitBtn" class="btn btn-success" style="margin-top: 20px;">
                        Update
                        </button>
                        <a href="{{ route('admin.time-table') }}" class="btn btn-danger" style="margin-top: 20px;">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Script for getting the selected sections in case of edit function and getting sections by class -->
<script>
    $(document).ready(function() {
        var selectedSection = "{{ old('sections', $entry->sections ?? '') }}"; // Get previous section

        function loadSections(classId, selectedSection) {
            if (classId) {
                $.ajax({
                    url: '{{ url("get-sections") }}/' + classId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        console.log("Sections Received:", data);
                        
                        $('#sections').empty().append('<option value="">Select Section</option>');
                        $.each(data, function(id, title) {
                            var selected = (id == selectedSection) ? 'selected' : ''; // Check if it's the previously selected section
                            $('#sections').append('<option value="' + id + '" ' + selected + '>' + title + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", error);
                        alert('Unable to fetch sections.');
                    }
                });
            } else {
                $('#sections').empty().append('<option value="">Select Section</option>');
            }
        }

        $('#classes').on('change', function() {
            var classId = $(this).val();
            console.log("Selected Class ID:", classId);
            loadSections(classId, "");
        });

        // Trigger change event to reload sections if a class was already selected in edit mode
        var selectedClass = $('#classes').val();
        if (selectedClass) {
            loadSections(selectedClass, selectedSection);
        }
    });
</script>

<!-- Script for checking whether the particular teacher is assigned in the particular period and weekday or not -->
<script>
    $(document).ready(function() {
        $('#weekdays, #periods, #teachers').on('change', function() {
            var teacherId = $('#teachers').val();
            var periodId = $('#periods').val();
            var weekdayId = $('#weekdays').val();
            var currentEntryId = "{{ $entry->id }}"; // Get the current entry ID

            if (teacherId && periodId && weekdayId) {
                $.ajax({
                    url: '{{ url("admin/time-table/check-teacher-availability") }}',
                    type: 'GET',
                    data: {
                        teacher_id: teacherId,
                        period_id: periodId,
                        weekday_id: weekdayId,
                        entry_id: currentEntryId // Pass current entry ID to exclude it from the check
                    },
                    success: function(response) {
                        if (response.exists) {
                            alert("This teacher is already assigned for this period on the same weekday.");
                            $('#submitBtn').prop('disabled', true);
                        } else {
                            $('#submitBtn').prop('disabled', false);
                        }
                    }
                });
            }
        });
    });
</script>

@include('layouts.a_footer')