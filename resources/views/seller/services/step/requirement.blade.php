<style>
  .form-row-between {
    width: 100%;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
  }

  .auto-row {
    width: auto;
    display: flex;
    align-items: center;
  }

  .form-select.auto-row {
    min-width: 400px;
  }

  .check-input {
    margin: 0;
    margin-right: 4px;
    cursor: pointer;
  }

  .check-label {
    margin: 0;
    cursor: pointer;
  }

  .add-requirement {
    display: flex;
    flex-direction: column;
    width: 100%;
    border: 1px solid #ced4da;
    border-radius: 4px;
    padding: 20px;
  }

  .select-option {
    padding: 0.375rem 0.75rem 0.375rem 0.75rem;
    -moz-padding-start: calc(0.75rem - 3px);
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #212529;
    border: 1px solid #ced4da;
    border-radius: 0.375rem;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    margin-bottom: 0.5rem;
  }

  .select-option .remove-btn {
    font-size: 20px;
    color: black;
    opacity: 0.7;
    cursor: pointer;
    line-height: 1;
  }

  .select-option .remove-btn:hover {
    opacity: 1;
  }

  .select-option .choice-input {
    margin: 0;
    padding: 0;
    outline: 0;
    width: 100%;
    border: 0;
  }
</style>

<form action="{{ route('seller.services.requirement') }}" method="post" enctype="multipart/form-data">
  <div class="row">
      <div class="col-md-12">
          @csrf
          <div class="card col-md-12 mb-4">
              <!-- Header -->
              <div class="card-header">
                  <h4 class="card-header-title mb-0">Service information</h4>
              </div>
              <!-- End Header -->
              <div class="card-body">
                  <input type="hidden" name="step" id="name" value="{{$step}}" class="form-control">
                  <input type="hidden" name="service_id" id="service_id" value="{{$post_id}}" >
                  @include('includes.validation-form')

                  <label class="fs-4 mb-2">Questions</label>
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Question</th>
                        <th scope="col">Type</th>
                        <th scope="col">Required</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody id="table-body">
                      @foreach ($data->requirements as $key => $requirement)
                      <tr id="question-{{ $key + 1 }}">
                        <th class="id">{{ $key + 1 }}</th>
                        <td class="question">{{ $requirement->question }}</td>
                        <td class="type">{{ $requirement->type == 0 ? "Text" : ($requirement->type == 1 ? "Attachment" : "Multiple choice" ) }}</td>
                        <td class="required">{{ $requirement->required == 1 ? "true" : "false" }}</td>
                        <td>
                          <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-xs btn-primary edit-question" onClick="editClick(this);">Edit</button>
                            <button type="button" class="btn btn-xs btn-danger delete-question" onClick="removeClick(this)">Delete</button>
                          </div>
                        </td>
                        <input class="id-value" type="hidden" name="id[]" value="{{ $requirement->id }}">
                        <input class="question-value" type="hidden" name="question[]" value="{{ $requirement->question }}">
                        <input class="type-value" type="hidden" name="type[]" value="{{ $requirement->type }}">
                        <input class="required-value" type="hidden" name="required[]" value="{{ $requirement->required == 1 ? "true" : "false" }}">
                        <input class="choices" type="hidden" name="choices[]" value="{{ $requirement->choices_str }}">
                      </tr>
                      @endforeach
                    </tbody>
                  </table>

                  <div class="add-requirement">
                    <div class="form-row-between mb-3">
                      <label class="fs-3">Add a question</label>
                      <div class="auto-row">
                        <input class="check-input" type="checkbox" id="require-check">
                        <label class="check-label" for="require-check">
                          Required
                        </label>
                      </div>
                    </div>
                    <div class="form-group mb-5">
                      <textarea type="text" class="form-control" id="question" placeholder="Type question here"></textarea>
                    </div>
                    <div class="form-group">
                      <label class="fs-4 mb-3">Get it in a form of:</label>
                      <div class="form-row-between">
                        <select class="form-select auto-row" aria-label="Default select example" id="type-select">
                          <option value="0" selected>Text</option>
                          <option value="1">Attachment</option>
                          <option value="2">Multiple Choice</option>
                        </select>
                        <div class="auto-row" id="enable-multi-container">
                          <input class="check-input" type="checkbox" id="enable-multi-check">
                          <label class="check-label" for="enable-multi-check">
                            Enable to choose more than 1 option
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group" id="multichoice-setting">
                      <div class="col" id="options">
                      </div>
                      <button type="button" class="btn btn-primary" id="add-choice-button">+ Add New Option</button>
                    </div>
                    <div class="form-row d-flex justify-content-end gap-2">
                      <button type="button" class="btn btn-success" id="add-question">Add</button>
                    </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <div class="row justify-content-center justify-content-sm-between">
      <div class="col">
      <a type="button" class="btn btn-danger" href="{{route('seller.services.list')}}">Cancel</a>
      </div>
      <!-- End Col -->

      <div class="col-auto">
      <div class="d-flex flex-column gap-3">
          <!-- <button type="button" class="btn btn-light">Save Draft</button> -->
          <button type="submit" class="btn btn-primary">Save & Continue</button>
          <a type="button" class="btn btn-light" href="{{"/seller/services/create/".($step-1)."/".$post_id}}">Back</a> 
      </div>
      </div>
      <!-- End Col -->
  </div>
  <!-- End Card -->
</div>
</form>
</div>

@section('js')
<script>
  var currentRow = {!! count($data->requirements) !!};
  var selectedRow = -1;
  $(document).ready(() => {
    $('#type-select').on('change', function() {
      freshSelect()
    });

    freshSelect()


    $('#add-choice-button').click(function () {
      var options = $('#options').children();
      for (const option of options) {
        if ($(option).find('input').val() == '') {
          window.alert("You have empty choice now");
          return;
        }
      }
      $('#options').append(
        '<div class="select-option selected form-row-between">\
          <input class="choice-input" value="">\
          <span class="remove-btn" onclick="removeChoice(this);">&#215</span>\
        </div>'
      );
    })

    $('#add-question').click(function() {
      var question = $('#question').val();
      var required = $('#require-check').is(":checked");
      var type = parseInt($('#type-select').val());
      var typeStr = type == 0 ? "Text" : type == 1 ? "Attachment" : "Multiple choice";

      if (type == 2) {
        type += $('#enable-multi-check').is(":checked") ? 1 : 0;
      }

      var choices = [];
      var choiceInputs = $('.choice-input');
      for (var i=0; i < choiceInputs.length; i++) {
        if ($(choiceInputs[i]).val().length > 0) {
          choices.push($(choiceInputs[i]).val());
        };
      }
      if (selectedRow < 0) {
        currentRow ++;
        var htmlItem = `<tr id="question-${currentRow}">\
                          <th class="id">${currentRow}</th>\
                          <td class="question">${question}</td>\
                          <td class="type">${typeStr}</td>\
                          <td class="required">${required}</td>\
                          <td>\
                            <div class="btn-group" role="group" aria-label="Basic example">\
                              <button type="button" class="btn btn-xs btn-primary edit-question" onClick="editClick(this);">Edit</button>\
                              <button type="button" class="btn btn-xs btn-danger delete-question" onClick="removeClick(this)">Delete</button>\
                            </div>\
                          </td>`;

        htmlItem += `<input class="id-value" type="hidden" name="id[]" value="-1">\
                    <input class="question-value" type="hidden" name="question[]" value="${question}">\
                    <input class="type-value" type="hidden" name="type[]" value="${type}">\
                    <input class="required-value" type="hidden" name="required[]" value="${required}">\
                    <input class="choices" type="hidden" name="choices[]" value="${choices.join(',')}">\
                  </tr>`

        $('#table-body').append(htmlItem);
      } else {
        var idStr = `#question-${selectedRow + 1}`;
        console.log(idStr);
        var row = $(idStr);
        console.log(row);
        row.find('.question').text(question);
        row.find('.type').text(typeStr);
        row.find('.required').text(required);
        
        row.find('.question-value').val(question);
        row.find('.type-value').val(type);
        row.find('.required-value').val(required);
        row.find('.choices').val(choices.join(','));

        selectedRow = -1;
      }

      $('#question').val("");
      $('#require-check').prop('checked', false);
      $('#type-select').val(0);
      $('#enable-multi-check').prop('checked', false);

      $('#options').empty();

      freshSelect();
      
      $('#add-question').text("Add")
    })
  })

  function editClick(item) {
    var row = $(item).parent().parent().parent();
    var rowId = parseInt(row.find('.id').text()) - 1;
    var question = row.find('.question').text();
    var type = parseInt(row.find('.type-value').val());
    var required = row.find('.required-value').val() == 'true' ? true : false;
    var choices = row.find('.choices').val().split(',');

    selectedRow = rowId;

    $('#question').val(question);
    $('#require-check').prop('checked', required);
    $('#type-select').val(type > 2 ? 2 : type);
    if (type > 2) {
      $('#enable-multi-check').prop('checked', true);
    }

    $('#options').empty();

    for(var i=0; i<choices.length; i++) {
      $('#options').append(
        `<div class="select-option selected form-row-between">\
          <input class="choice-input" value="${choices[i]}">\
          <span class="remove-btn" onclick="removeChoice(this);">&#215</span>\
        </div>`
      );
    }

    freshSelect()

    $('#add-question').text("Save")
  };

  function removeClick(item) {
    $(item).parent().parent().parent().remove();
  };

  function removeChoice(item) {
    $(item).parent().remove();
  }

  function freshSelect() {
    if ($('#type-select').val() != 2) {
        $('#multichoice-setting').hide();
        $('#enable-multi-container').hide();
    }
    else {
        $('#multichoice-setting').show();
        $('#enable-multi-container').show();
    }
  }
</script>
@endsection