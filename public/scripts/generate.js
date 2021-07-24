$(document).ready(function() {
    GenerateReplyApp = new GenerateReplyApp();
    GenerateReplyApp.init();
});

function GenerateReplyApp() {
    this.instance;

    this.init = function () {
        $("#generate-platform-div").show();

        this.platformChangeListener();
        this.gameChangeListener();
        this.categoryChangeListener();
        this.generateReplyButtonClickListener();
        this.generateNextReplyButtonClickListener();
        this.copyToClipboardClickListener();

        if (GenerateReplyApp.instance == null) {
            GenerateReplyApp.instance = this;
        }
    }
    
    /* Handles events for when platform select changes */
    this.platformChangeListener = function() {
        $("#generate-platform-select").change(function() {
            var platform_id = parseInt($(this).val());
            if (Number.isInteger(platform_id)) {
                GenerateReplyApp.instance.restartGenerateProcess(false);
                GenerateReplyApp.instance.getGamesByPlatform(platform_id);
            }
        });
    }

    /* Handles events for when game select changes */
    this.gameChangeListener = function() {
        $("#generate-game-select").change(function() {
            $("#generate-review-category-div").show();
            GenerateReplyApp.instance.restartGenerateProcess(true);
        });
    }

    /* Handles events for when category select changes */
    this.categoryChangeListener = function() {
        $("#generate-review-category-select").change(function() {
            GenerateReplyApp.instance.restartGenerateProcess(true);
        });
    }

    /* Handles events for when generate reply button is clicked */
    this.generateReplyButtonClickListener = function() {
        $("#generate-reply-button").click(function() {
            GenerateReplyApp.instance.generateReply();
        });
    }

    /* Handles events for when next reply button is clicked */
    this.generateNextReplyButtonClickListener = function() {
        $("#generate-next-reply-button").click(function() {
            var previous_reply_id = $("#hidden_reply_id").val();
            GenerateReplyApp.instance.generateReply(previous_reply_id);
        });
    }

    /* Sends ajax request for all games for a given platform */
    this.getGamesByPlatform = function (platform_id) {
        $("#generate-game-div").show();
        $("#generate-game-select option[data-reset]").remove();

        $.get( `/usedReplies/getGamesByPlatform/${platform_id}`, function( data ) {
            var obj = JSON.parse(data);
            for (var key in obj){
              var value = obj[key];
              var html = `<option value="${value.id}" data-reset='true'>${value.name}</option>`;
              $("#generate-game-select").append($.parseHTML(html));
            }
        });
    }

    /* Where the magic happens. Generates a reply based on a set of conditions */
    this.generateReply = function(previous_reply_id = null) {
        var platform_id = parseInt($("#generate-platform-select").val());
        var game_id = parseInt($("#generate-game-select").val());
        var review_category_id = parseInt($("#generate-review-category-select").val());

        var data = new Object();
        data.platform_id = platform_id;
        data.game_id = game_id;
        data.review_category_id = review_category_id;

        $.ajax({
            type: "POST",
            url: (previous_reply_id == null) ? '/usedReplies/generateReply' : `/usedReplies/generateReply/${previous_reply_id}`,
            data : JSON.stringify(data),
            contentType: 'application/json',
        }).done(function( data ) {
            var obj = JSON.parse(data);

            if (obj != null) {
                GenerateReplyApp.instance.generatedReplyFound(obj);
            } else {
                $("#generate-reply-text-div").hide();
                if (swal != undefined && swal != null) {
                    swal("Sorry!", "There was no reply data found. This usually means a reply for your specified review category has not been created yet!", "error");
                } else {
                    $("#no-reply-found-div").show();
                }
            }
        });
    }
    
    /* Called to reset the forms & buttons in the generation process */
    this.restartGenerateProcess = function(bCanShowGenerateButton) {
        if (bCanShowGenerateButton) $("#generate-reply-button").show();
        $("#generate-next-reply-button").hide();
        $("#generate-reply-text-div").hide();
        $("#confirm-generated-reply-button").hide();
    }

    /* Called when generated reply data is found */
    this.generatedReplyFound = function(obj)
    {
        $("#no-reply-found-div").hide();
        $("#hidden_reply_id").val(obj.id);
        $("#textarea_reply_text").text(obj.text);
        $("#generate-reply-text-div").show();
        $("#generate-reply-button").hide();
        $("#confirm-generated-reply-button").show();
        $("#generate-next-reply-button").show();
    }

    /* copy to clip board click listener */
    this.copyToClipboardClickListener = function() {
        document.getElementById("copy-to-clipboard-button").addEventListener("click", function() {
            if (GenerateReplyApp.instance.copyToClipboard(document.getElementById("textarea_reply_text"))) {
                swal("Success!", "The reply text was copied to your clipboard!", "success");
            }
        });
    }

    /* Copies reply to clipboard */
    this.copyToClipboard = function(elem) {
        // create hidden text element, if it doesn't already exist
        var targetId = "_hiddenCopyText_";
        var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
        var origSelectionStart, origSelectionEnd;
        if (isInput) {
            // can just use the original source element for the selection and copy
            target = elem;
            origSelectionStart = elem.selectionStart;
            origSelectionEnd = elem.selectionEnd;
        } else {
            // must use a temporary form element for the selection and copy
            target = document.getElementById(targetId);
            if (!target) {
                var target = document.createElement("textarea");
                target.style.position = "absolute";
                target.style.left = "-9999px";
                target.style.top = "0";
                target.id = targetId;
                document.body.appendChild(target);
            }
            target.textContent = elem.textContent;
        }
        // select the content
        var currentFocus = document.activeElement;
        target.focus();
        target.setSelectionRange(0, target.value.length);
        
        // copy the selection
        var succeed;
        try {
                succeed = document.execCommand("copy");
        } catch(e) {
            succeed = false;
        }
        // restore original focus
        if (currentFocus && typeof currentFocus.focus === "function") {
            currentFocus.focus();
        }
        
        if (isInput) {
            // restore prior selection
            elem.setSelectionRange(origSelectionStart, origSelectionEnd);
        } else {
            // clear temporary content
            target.textContent = "";
        }
        return succeed;
    }
}