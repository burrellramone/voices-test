document.addEventListener('DOMContentLoaded', function(e){
    //add job form
    var addJobForm = document.getElementById('ajf');
    //additional information textarea
    var ai = document.getElementById('additional-information');
    //country select
    var countryEl = document.getElementById('country-id');
    //delete job links
    var deleteJobLinks = document.getElementsByClassName('djl');
    //remove alert buttons
    var removeAlertButtons = document.getElementsByClassName('close');

    if(ai){
        ['keyup', 'change'].forEach((type) => {
            ai.addEventListener(type, function(event) {
                var counterEl = document.getElementById('ai-counter');
                var countEl = counterEl.querySelector('.count');
                var value = ai.value;
                var words = value.split(' ');
                words = words.filter(function (el) {
                    return el != null && el !== '';
                });
        
                countEl.innerHTML = words.length;
            });
        });        
    }

    if(countryEl){
        var stateEl = document.getElementById('location-id');

        countryEl.addEventListener('change', function(event){
            var country_id = countryEl.value;
            var country_states = states[country_id] ? states[country_id] : [];

            while(stateEl.childElementCount > 1) {
                var childOption = stateEl.childNodes[stateEl.childElementCount];
                stateEl.removeChild(childOption);
            }

            stateEl.setAttribute('disabled', 'disabled');
            stateEl.value = '';

            if(country_states.length){
                for(var i = 0; i < country_states.length; i++) {
                    var state = country_states[i];
                    var option = document.createElement("option");
                    option.innerHTML = state.locale_name;
                    option.value = state.id;
    
                    stateEl.appendChild(option);
                }

                stateEl.removeAttribute('disabled');
            }
        });
    }

    if(deleteJobLinks.length){
        for(var i = 0; i < deleteJobLinks.length; i++) {
            var link = deleteJobLinks[i];

            link.addEventListener('click', function(e){
                e.preventDefault();

                var result = confirm("Delete this job, are you sure?");

                if(result){
                    window.location = link.getAttribute('href');
                }

                return false;
            });
        }
    }

    if(removeAlertButtons.length){
        for(var i = 0; i < removeAlertButtons.length; i++) {
            var button = removeAlertButtons[i];

            button.addEventListener('click', function(e){
                e.target.parentNode.remove();
            });
        }
    }

    if(addJobForm){
        function getFormValidatableFields(form) {
            var validatableInputs = [];
            var inputs = form.getElementsByTagName('input');
            var selects = form.getElementsByTagName('select');
            var textareas = form.getElementsByTagName('textarea');

            for(var i = 0; i < inputs.length; i++){
                validatableInputs.push(inputs.item(i));
            }

            for(var i = 0; i < selects.length; i++){
                validatableInputs.push(selects.item(i));
            }

            for(var i = 0; i < textareas.length; i++){
                validatableInputs.push(textareas.item(i));
            }

            return validatableInputs;
        }

        function createInputErrorMessageEl(message){
            var errorMessageEl = document.createElement('div');
            errorMessageEl.className = "form-field-error";
            errorMessageEl.innerHTML = message;
            return errorMessageEl;
        }

        function removeFormFieldValidationErrors(form){
            var allFields = getFormValidatableFields(form);

            allFields.forEach((field) => {
                //remove existing error message for field, if any and
                //remove invalid class
                var formFieldError = field.parentNode.querySelector('.form-field-error');
                
                field.classList.remove('invalid');

                if(formFieldError) {
                    formFieldError.remove();
                }
            });
        }

        function validateFormFields(form, input){
            var formValid = true;
            var allFields = getFormValidatableFields(form);
            var fieldsToValidate = input ? [input] : allFields;

            fieldsToValidate.forEach((field) => {
                if(!formValid){
                    return;
                }

                //remove existing error message for field, if any and
                //remove invalid class
                var formFieldError = field.parentNode.querySelector('.form-field-error');
                
                field.classList.remove('invalid');

                if(formFieldError) {
                    formFieldError.remove();
                }

                if(field.validationMessage){
                    errorMesage = createInputErrorMessageEl(field.validationMessage);
                    field.insertAdjacentElement('afterend', errorMesage);
                    field.classList.add('invalid');
                    formValid = false;
                }
            });

            return formValid;
        }

        async function listener(e){
            //wait 1/4 second before dispatching "change" event on country select field
            //as value for the select does not actually change until the form reset event
            //is completed
            await new Promise(resolve => setTimeout(resolve, 250));

            removeFormFieldValidationErrors(e.target);
            countryEl.dispatchEvent(new Event("change"));
            ai.dispatchEvent(new Event("change"));
        }

        addJobForm.addEventListener("reset", listener);

        addJobForm.addEventListener("submit", function(e){
            var submitButton = addJobForm.querySelector('[type="submit"]');
            var formValid = validateFormFields(addJobForm);

            if(!formValid){
                return e.preventDefault();
            }

            //form will submit, prevent submitting twice
            submitButton.setAttribute("disabled", "disabled");
            submitButton.classList.add("disabled");
        });

        var addJobFormValidatableInputs = getFormValidatableFields(addJobForm);

        addJobFormValidatableInputs.forEach((input) => {
            ['blur', 'change'].forEach(function(type){
                input.addEventListener(type, function(e){
                    var currentValue = input.value ? input.value : null;
                    var previousValue = input.previousValue ? input.previousValue : null;

                    if(previousValue == currentValue){
                        //input value didn't change, so don't trigger form validation on it
                        return;
                    }

                    input.previousValue = currentValue;
                    validateFormFields(addJobForm, e.target);
                });
            });
        });
    }
});