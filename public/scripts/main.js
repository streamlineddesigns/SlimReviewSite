$(document).ready(function() {
    FunApp = new FunApp();
    FunApp.initContent();
    FunApp.initActiveNavBarLink();
    FunApp.initMultiSelect();
    FunApp.initBootstrapTables();
});

function FunApp() {
    this.multiSelect = $('#multiSelect');
    this.multiSelectTableString;
    this.multiSelectOptions = $('#multiSelect option');
    this.multiSelectValues;
    this.hiddenInput;
    this.inputFormCode;

    this.initContent = function() {
        $("#content").ready(function() {
            if ($("#content").find(".bootstrap-table").length !== 0) {
                //indexs have tables
            } else {
                $("#content").addClass("smaller-container");
            }
        });
    }

    this.initActiveNavBarLink = function() {
        var first = $(location).attr('pathname');
        first.indexOf(1);
        first.toLowerCase();
        first = "/" + first.split("/")[1];
        $('a[href="' + first + '"]').closest('.nav-link').addClass('active');
    };
    
    this.initMultiSelect = function() {
        if (this.multiSelect) {
            this.multiSelectTableString = this.multiSelect.attr("data-table-string");
            this.inputFormCode = $.parseHTML(`<input type='hidden' name='${this.multiSelectTableString}' id='${this.multiSelectTableString}'>`);
            this.multiSelect.after(this.inputFormCode);
            this.hiddenInput = $(`#${this.multiSelectTableString}`);
            FunApp.multiSelectClickHandler();
            this.registerMultiSelectClickListeners();
        }
    };

    this.registerMultiSelectClickListeners = function() {
        this.multiSelect.click(function() {
            FunApp.multiSelectClickHandler();
        });

        this.multiSelectOptions.click(function() {
            $(this).toggleClass("selected-option");
        });
    };

    this.multiSelectClickHandler = function() {
        this.multiSelectValues = [];
        $(".selected-option").each(function() {
            FunApp.multiSelectValues.push($(this).val());
        });
        this.hiddenInput.val(this.multiSelectValues);
    };

    this.initBootstrapTables = function() {
        $(".search").ready(function() {
            var html = 
            `
            <div class="input-group-text custom-group-text">
                <i class="bi bi-search"></i>
            </div>
            `;
            $(".search-input").before($.parseHTML(html));
        });
    };

    this.backButtonClick = function() {
        window.history.back();
    };

    this.deleteResource = function(id, resource_string_name, form_id) {
        if (swal) {
            swal({
                title: `Delete this ${resource_string_name} data?`,
                text: "Once deleted, you may not ever be able to recover the data!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    var deleteForm = `#${form_id}`;
                    $(deleteForm).submit();
                } else {
                  swal(`Your ${resource_string_name} data is safe!`, {
                    icon: "success"
                  });
                }
            });
        } 
    }
}