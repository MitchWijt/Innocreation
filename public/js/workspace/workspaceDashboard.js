var counter = 0;
$(document).ready(function() {
    $(".mostTicketsCategory").text("Week");
    function getDashboardData() {
        var team_id = $(".team_id").val();
        var user_id = $(".user_id").val();

        var totalTeamChatsNow = $(".totalTeamChats24Hours").val();
        var percentageTotalTeamChats = 0;

        var totalAssistanceTicketsNow = $(".totalAssistanceTickets24Hours").val();
        var percentageTotalAssistanceTickets = 0;

        var totalAssistanceTicketsCompletedNow = $(".totalAssistanceTicketsCompleted24Hours").val();
        var percentageTotalAssistanceTicketsCompleted = 0;
        $.ajax({
            method: "POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            url: "/workspace/getRealtimeDataDashboard",
            dataType: "JSON",
            data: {'user_id': user_id, 'team_id': team_id},
            success: function (data) {
                //Total team chats
                var valueTotalTeamChats = 0;
                if(totalTeamChatsNow != 0) {
                    if (data['totalTeamChats'] > parseInt(totalTeamChatsNow)) {
                        valueTotalTeamChats = parseInt(totalTeamChatsNow);
                        percentageTotalTeamChats = (data['totalTeamChats'] - valueTotalTeamChats) / valueTotalTeamChats * 100;
                        $(".totalTeamChatsValUp").removeClass("hidden");
                        $(".totalTeamChatsValNeutral").addClass("hidden");
                        $(".totalTeamChatsValDown").addClass("hidden");
                    } else if (data['totalTeamChats'] < parseInt(totalTeamChatsNow)) {
                        valueTotalTeamChats = parseInt(totalTeamChatsNow);
                        percentageTotalTeamChats = (data['totalTeamChats'] - valueTotalTeamChats) / valueTotalTeamChats * 100;
                        $(".totalTeamChatsValUp").addClass("hidden");
                        $(".totalTeamChatsValNeutral").addClass("hidden");
                        $(".totalTeamChatsValDown").removeClass("hidden");
                    } else {
                        $(".totalTeamChatsValUp").addClass("hidden");
                        $(".totalTeamChatsValDown").addClass("hidden");
                        $(".totalTeamChatsValNeutral").removeClass("hidden");
                        $(".totalTeamChats").text(data["totalTeamChats"]);
                        $(".totalTeamChatsPercentage").text("- ").append("% ");
                    }

                    if (percentageTotalTeamChats.toFixed(2) != 0.00) {
                        $(".totalTeamChats").text(data["totalTeamChats"]);
                        $(".totalTeamChatsPercentage").text(percentageTotalTeamChats.toFixed(2).replace("-", "")).append("% ");
                    }
                    if (data['totalTeamChats'] == 0 && totalTeamChatsNow == 0) {
                        $(".totalTeamChats").text(0);
                        $(".totalTeamChatsPercentage").text("- ").append("% ");
                    }
                } else {
                    $(".totalTeamChats").text(data["totalTeamChats"]);
                    $(".totalTeamChatsPercentage").text("- ").append("% ");
                    $(".totalTeamChatsValNeutral").removeClass("hidden");
                }

                //Total assistance tickets
                var valueTotalAssistanceTickets = 0;
                if(totalAssistanceTicketsNow != 0) {
                    if (data['totalAssistanceTickets'] > parseInt(totalAssistanceTicketsNow)) {
                        valueTotalAssistanceTickets = parseInt(totalAssistanceTicketsNow);
                        percentageTotalAssistanceTickets = (data['totalAssistanceTickets'] - valueTotalAssistanceTickets) / valueTotalAssistanceTickets * 100;
                        $(".totalAssistanceTicketsValUp").removeClass("hidden");
                        $(".totalAssistanceTicketsValNeutral").addClass("hidden");
                        $(".totalAssistanceTicketsValDown").addClass("hidden");
                    } else if (data['totalAssistanceTickets'] < parseInt(totalAssistanceTicketsNow)) {
                        valueTotalAssistanceTickets = parseInt(totalAssistanceTicketsNow);
                        percentageTotalAssistanceTickets = (data['totalAssistanceTickets'] - valueTotalAssistanceTickets) / valueTotalAssistanceTickets * 100;
                        $(".totalAssistanceTicketsValUp").addClass("hidden");
                        $(".totalAssistanceTicketsValNeutral").addClass("hidden");
                        $(".totalAssistanceTicketsValDown").removeClass("hidden");
                    } else {
                        $(".totalAssistanceTicketsValUp").addClass("hidden");
                        $(".totalAssistanceTicketsValDown").addClass("hidden");
                        $(".totalAssistanceTicketsValNeutral").removeClass("hidden");
                        $(".totalAssistanceTickets").text(data["totalAssistanceTickets"]);
                        $(".totalAssistanceTicketsPercentage").text("- ").append("% ");
                    }
                    if (percentageTotalAssistanceTickets.toFixed(2) != 0.00) {
                        $(".totalAssistanceTickets").text(data["totalAssistanceTickets"]);
                        $(".totalAssistanceTicketsPercentage").text(percentageTotalAssistanceTickets.toFixed(2).replace("-", "")).append("% ");
                    }
                    if (data['totalAssistanceTickets'] == 0 && totalAssistanceTicketsNow == 0) {
                        $(".totalAssistanceTickets").text(0);
                        $(".totalAssistanceTicketsPercentage").text("- ").append("% ");
                    }
                } else {
                    $(".totalAssistanceTicketsValNeutral").removeClass("hidden");
                    $(".totalAssistanceTickets").text(data["totalAssistanceTickets"]);
                    $(".totalAssistanceTicketsPercentage").text("- ").append("% ");
                }

                //Total assistanceTickets completed
                var valueTotalAssistanceTicketsCompleted = 0;
                if(totalAssistanceTicketsCompletedNow != 0) {
                    if (data['totalAssistanceTicketsCompleted'] > parseInt(totalAssistanceTicketsCompletedNow)) {
                        valueTotalAssistanceTicketsCompleted = parseInt(totalAssistanceTicketsCompletedNow);
                        percentageTotalAssistanceTicketsCompleted = (data['totalAssistanceTicketsCompleted'] - valueTotalAssistanceTicketsCompleted) / valueTotalAssistanceTicketsCompleted * 100;
                        $(".totalAssistanceTicketsCompletedValUp").removeClass("hidden");
                        $(".totalAssistanceTicketsCompletedValNeutral").addClass("hidden");
                        $(".totalAssistanceTicketsCompletedValDown").addClass("hidden");
                    } else if (data['totalAssistanceTicketsCompleted'] < parseInt(totalAssistanceTicketsCompletedNow)) {
                        valueTotalAssistanceTicketsCompleted = parseInt(totalAssistanceTicketsCompletedNow);
                        percentageTotalAssistanceTicketsCompleted = (data['totalAssistanceTicketsCompleted'] - valueTotalAssistanceTicketsCompleted) / valueTotalAssistanceTicketsCompleted * 100;
                        $(".totalAssistanceTicketsCompletedValUp").addClass("hidden");
                        $(".totalAssistanceTicketsCompletedValNeutral").addClass("hidden");
                        $(".totalAssistanceTicketsCompletedValDown").removeClass("hidden");
                    } else {
                        $(".totalAssistanceTicketsCompletedValUp").addClass("hidden");
                        $(".totalAssistanceTicketsCompletedValDown").addClass("hidden");
                        $(".totalAssistanceTicketsCompletedValNeutral").removeClass("hidden");
                        $(".totalAssistanceTicketsCompleted").text(data["totalAssistanceTicketsCompleted"]);
                        $(".totalAssistanceTicketsCompletedPercentage").text("- ").append("% ");
                    }

                    if (percentageTotalAssistanceTicketsCompleted.toFixed(2) != 0.00) {
                        $(".totalAssistanceTicketsCompleted").text(data["totalAssistanceTicketsCompleted"]);
                        $(".totalAssistanceTicketsCompletedPercentage").text(percentageTotalAssistanceTicketsCompleted.toFixed(2).replace("-", "")).append("% ");
                    }
                    if (data['totalAssistanceTicketsCompleted'] == 0 && totalAssistanceTicketsCompletedNow == 0) {
                        $(".totalAssistanceTicketsCompleted").text(0);
                        $(".totalAssistanceTicketsCompletedPercentage").text("- ").append("% ");
                    }
                } else {
                    $(".totalAssistanceTicketsCompleted").text(data["totalAssistanceTicketsCompleted"]);
                    $(".totalAssistanceTicketsCompletedPercentage").text("- ").append("% ");
                    $(".totalAssistanceTicketsCompletedValNeutral").removeClass("hidden");
                }
            }
        });
        var category = $(".mostTicketsCategory").text();
        $.ajax({
            method: "POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            url: "/workspace/changeMostAssistanceTicketsCategory",
            dataType: "JSON",
            data: {'user_id': user_id, 'team_id': team_id, 'category' : category},
            success: function (data) {
                $(".mostTicketsMember").text(data['member']);
                $(".mostTicketsValue").text(data['tickets']);
                $(".mostTicketsCategory").text(data['category']);
            }
        });
    }
    getDashboardData();
    setInterval(function () {
        counter++;
        getDashboardData();
    }, 15000);
});

$(document).ready(function () {
   $(".chatsDashboardMenu").removeClass("hidden");
   $(".chatsDashboardMenu").toggle();
});

$(".chatsDashboardMenuToggle").on("click",function () {
    $(".chatsDashboardMenu").toggle();
});

$(".changeCategoryMostTickets").on("click",function () {
    var team_id = $(".team_id").val();
    var user_id = $(".user_id").val();
    var category = $(this).text();
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/workspace/changeMostAssistanceTicketsCategory",
        dataType: "JSON",
        data: {'user_id': user_id, 'team_id': team_id, 'category' : category},
        success: function (data) {
            $(".mostTicketsMember").text(data['member']);
            $(".mostTicketsValue").text(data['tickets']);
            $(".mostTicketsCategory").text(data['category']);
            $(".chatsDashboardMenu").toggle();
        }
    });
});


$(document).ready(function() {
    var team_id = $(".team_id").val();
    var user_id = $(".user_id").val();
    function getDashboardDataMemberTaskListCompleted() {
        $.ajax({
            method: "POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            url: "/workspace/getMemberTaskListData",
            dataType: "JSON",
            data: {'user_id': user_id, 'team_id': team_id},
            success: function (data) {
                $.each(data, function(key, value) {
                    $(".memberTasksCom").each(function () {
                        if($(this).data("member-id") == key){
                            $(this).find(".memberTasksCompleted").text(value);
                        }
                    });
                });
            }
        });
    }
    function getDashboardDataMemberTaskListToDo() {
        var toDoTasks = 1;
        $.ajax({
            method: "POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            url: "/workspace/getMemberTaskListData",
            dataType: "JSON",
            data: {'user_id': user_id, 'team_id': team_id, 'toDo' : toDoTasks},
            success: function (data) {
                $.each(data, function(key, value) {
                    $(".memberTasksDo").each(function () {
                        if($(this).data("member-id") == key){
                            $(this).find(".memberTasksToDo").text(value);
                        }
                    });
                });
            }
        });
    }
    getDashboardDataMemberTaskListCompleted();
    getDashboardDataMemberTaskListToDo();
    setInterval(function () {
        getDashboardDataMemberTaskListCompleted();
        getDashboardDataMemberTaskListToDo
    }, 15000);
});
