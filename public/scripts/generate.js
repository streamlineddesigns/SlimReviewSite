$(document).ready(function() {
    GenerateReplyApp = new GenerateReplyApp();
    GenerateReplyApp.init();
});

function GenerateReplyApp() {
    this.instance;

    this.init = function () {
        this.platformChangeListener();
        this.gameChangeListener();
        this.categoryChangeListener();
        this.generateReplyButtonClickListener();

        if (GenerateReplyApp.instance == null) {
            GenerateReplyApp.instance = this;
        }
    }
    
    /* Handles events for when platform select changes */
    this.platformChangeListener = function() {
        $("#generate-platform-select").change(function() {
            var platform_id = parseInt($(this).val());
            if (Number.isInteger(platform_id)) {
                GenerateReplyApp.instance.getGamesByPlatform(platform_id);
            }
        });
    }

    /* Handles events for when game select changes */
    this.gameChangeListener = function() {
        $("#generate-game-select").change(function() {
            $("#generate-review-category-div").show();
        });
    }

    /* Handles events for when category select changes */
    this.categoryChangeListener = function() {
        $("#generate-review-category-select").change(function() {
            $("#generate-reply-button").show();
        });
    }

    /* Handles events for when generate reply button is clicked */
    this.generateReplyButtonClickListener = function() {
        $("#generate-reply-button").click(function() {
            GenerateReplyApp.instance.generateReply();
            $("#generate-reply-text-div").show();
            $("#confirm-generated-reply-button").show();
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
    this.generateReply = function() {
        var platform_id = parseInt($("#generate-platform-select").val());
        var game_id = parseInt($("#generate-game-select").val());
        var review_category_id = parseInt($("#generate-review-category-select").val());

        var data = new Object();
        data.platform_id = platform_id;
        data.game_id = game_id;
        data.review_category_id = review_category_id;

        $.ajax({
            type: "POST",
            url: '/usedReplies/generateReply',
            data : JSON.stringify(data),
            contentType: 'application/json',
        }).done(function( data ) {
            var obj = JSON.parse(data);
            console.log(obj);
            $("#hidden_reply_id").val(obj.id);
            $("#textarea_reply_text").text(obj.text);
        });
    }
}