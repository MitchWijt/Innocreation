$(document).ready(function() {
    $(".mostTicketsCategory").text("Week");
    getDashboardData();
    setInterval(function () {
        getDashboardData();
    }, 15000);
});
function getDashboardData() {
    var team_id = $(".team_id").val();
    var user_id = $(".user_id").val();

    var totalTeamChatsNow = $(".totalTeamChats24Hours").val();
    var newValueTotalTeamChats = 0;

    var totalAssistanceTicketsNow = $(".totalAssistanceTickets24Hours").val();
    var newValueTotalAssistanceTickets = 0;

    var totalAssistanceTicketsCompletedNow = $(".totalAssistanceTicketsCompleted24Hours").val();
    var newValueTotalAssistanceTicketsCompleted = 0;

    var completedGoalsNow = $(".completedGoals24Hours").val();
    var newValueCompletedGoals = 0;

    var unCompletedGoalsNow = $(".unCompletedGoals24Hours").val();
    var newValueUnCompletedGoals = 0;
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
                    newValueTotalTeamChats =  data['totalTeamChats'] - valueTotalTeamChats;
                    $(".totalTeamChatsValUp").removeClass("hidden");
                    $(".totalTeamChatsValNeutral").addClass("hidden");
                    $(".totalTeamChatsValDown").addClass("hidden");
                } else if (data['totalTeamChats'] < parseInt(totalTeamChatsNow)) {
                    valueTotalTeamChats = parseInt(totalTeamChatsNow);
                    newValueTotalTeamChats = (data['totalTeamChats'] - valueTotalTeamChats);
                    $(".totalTeamChatsValUp").addClass("hidden");
                    $(".totalTeamChatsValNeutral").addClass("hidden");
                    $(".totalTeamChatsValDown").removeClass("hidden");
                } else {
                    $(".totalTeamChatsValUp").addClass("hidden");
                    $(".totalTeamChatsValDown").addClass("hidden");
                    $(".totalTeamChatsValNeutral").removeClass("hidden");
                    $(".totalTeamChats").text(data["totalTeamChats"]);
                    $(".totalTeamChatsNewValue").text("- ");
                }

                if (newValueTotalTeamChats != 0) {
                    $(".totalTeamChats").text(data["totalTeamChats"]);
                    if(newValueTotalTeamChats > 0){
                        $(".totalTeamChatsNewValue").text("+ " + newValueTotalTeamChats);
                    } else {
                        $(".totalTeamChatsNewValue").text(newValueTotalTeamChats);
                    }
                }
                if (data['totalTeamChats'] == 0 && totalTeamChatsNow == 0) {
                    $(".totalTeamChats").text(0);
                    $(".totalTeamChatsNewValue").text("- ");
                }
            } else {
                $(".totalTeamChats").text(data["totalTeamChats"]);
                $(".totalTeamChatsNewValue").text("- ");
                $(".totalTeamChatsValNeutral").removeClass("hidden");
            }

            //Total assistance tickets
            var valueTotalAssistanceTickets = 0;
            if(totalAssistanceTicketsNow != 0) {
                if (data['totalAssistanceTickets'] > parseInt(totalAssistanceTicketsNow)) {
                    valueTotalAssistanceTickets = parseInt(totalAssistanceTicketsNow);
                    newValueTotalAssistanceTickets = data['totalAssistanceTickets'] - valueTotalAssistanceTickets;
                    $(".totalAssistanceTicketsValUp").removeClass("hidden");
                    $(".totalAssistanceTicketsValNeutral").addClass("hidden");
                    $(".totalAssistanceTicketsValDown").addClass("hidden");
                } else if (data['totalAssistanceTickets'] < parseInt(totalAssistanceTicketsNow)) {
                    valueTotalAssistanceTickets = parseInt(totalAssistanceTicketsNow);
                    newValueTotalAssistanceTickets = data['totalAssistanceTickets'] - valueTotalAssistanceTickets;
                    $(".totalAssistanceTicketsValUp").addClass("hidden");
                    $(".totalAssistanceTicketsValNeutral").addClass("hidden");
                    $(".totalAssistanceTicketsValDown").removeClass("hidden");
                } else {
                    $(".totalAssistanceTicketsValUp").addClass("hidden");
                    $(".totalAssistanceTicketsValDown").addClass("hidden");
                    $(".totalAssistanceTicketsValNeutral").removeClass("hidden");
                    $(".totalAssistanceTickets").text(data["totalAssistanceTickets"]);
                    $(".totalAssistanceTicketsNewValue").text("- ").append("% ");
                }
                if (newValueTotalAssistanceTickets != 0) {
                    $(".totalAssistanceTickets").text(data["totalAssistanceTickets"]);
                    if(newValueTotalAssistanceTickets > 0){
                        $(".totalAssistanceTicketsNewValue").text("+ " + newValueTotalAssistanceTickets);
                    } else {
                        $(".totalAssistanceTicketsNewValue").text(newValueTotalAssistanceTickets);
                    }
                }
                if (data['totalAssistanceTickets'] == 0 && totalAssistanceTicketsNow == 0) {
                    $(".totalAssistanceTickets").text(0);
                    $(".totalAssistanceTicketsNewValue").text("- ");
                }
            } else {
                $(".totalAssistanceTicketsValNeutral").removeClass("hidden");
                $(".totalAssistanceTickets").text(data["totalAssistanceTickets"]);
                $(".totalAssistanceTicketsNewValue").text("- ");
            }

            //Total assistanceTickets completed
            var valueTotalAssistanceTicketsCompleted = 0;
            if(totalAssistanceTicketsCompletedNow != 0) {
                if (data['totalAssistanceTicketsCompleted'] > parseInt(totalAssistanceTicketsCompletedNow)) {
                    valueTotalAssistanceTicketsCompleted = parseInt(totalAssistanceTicketsCompletedNow);
                    newValueTotalAssistanceTicketsCompleted = data['totalAssistanceTicketsCompleted'] - valueTotalAssistanceTicketsCompleted;
                    $(".totalAssistanceTicketsCompletedValUp").removeClass("hidden");
                    $(".totalAssistanceTicketsCompletedValNeutral").addClass("hidden");
                    $(".totalAssistanceTicketsCompletedValDown").addClass("hidden");
                } else if (data['totalAssistanceTicketsCompleted'] < parseInt(totalAssistanceTicketsCompletedNow)) {
                    valueTotalAssistanceTicketsCompleted = parseInt(totalAssistanceTicketsCompletedNow);
                    newValueTotalAssistanceTicketsCompleted = data['totalAssistanceTicketsCompleted'] - valueTotalAssistanceTicketsCompleted;
                    $(".totalAssistanceTicketsCompletedValUp").addClass("hidden");
                    $(".totalAssistanceTicketsCompletedValNeutral").addClass("hidden");
                    $(".totalAssistanceTicketsCompletedValDown").removeClass("hidden");
                } else {
                    $(".totalAssistanceTicketsCompletedValUp").addClass("hidden");
                    $(".totalAssistanceTicketsCompletedValDown").addClass("hidden");
                    $(".totalAssistanceTicketsCompletedValNeutral").removeClass("hidden");
                    $(".totalAssistanceTicketsCompleted").text(data["totalAssistanceTicketsCompleted"]);
                    $(".totalAssistanceTicketsCompletedNewValue").text("- ");
                }

                if (newValueTotalAssistanceTicketsCompleted != 0) {
                    $(".totalAssistanceTicketsCompleted").text(data["totalAssistanceTicketsCompleted"]);
                    if(newValueTotalAssistanceTicketsCompleted > 0){
                        $(".totalAssistanceTicketsCompletedNewValue").text("+ " + newValueTotalAssistanceTicketsCompleted);
                    } else {
                        $(".totalAssistanceTicketsCompletedNewValue").text(newValueTotalAssistanceTicketsCompleted);
                    }
                }
                if (data['totalAssistanceTicketsCompleted'] == 0 && newValueTotalAssistanceTicketsCompleted == 0) {
                    $(".totalAssistanceTicketsCompleted").text(0);
                    $(".totalAssistanceTicketsCompletedNewValue").text("- ");
                }
            } else {
                $(".totalAssistanceTicketsCompleted").text(data["totalAssistanceTicketsCompleted"]);
                $(".totalAssistanceTicketsCompletedNewValue").text("- ");
                $(".totalAssistanceTicketsCompletedValNeutral").removeClass("hidden");
            }

            // Total bucketlist goals completed
            var valueCompletedGoals = 0;
            if(completedGoalsNow != 0) {
                if (data['totalCompletedGoals'] > parseInt(completedGoalsNow)) {
                    console.log("up");
                    valueCompletedGoals = parseInt(completedGoalsNow);
                    newValueCompletedGoals =  data['totalCompletedGoals'] - valueCompletedGoals;
                    $(".completedGoalsValUp").removeClass("hidden");
                    $(".completedGoalsValNeutral").addClass("hidden");
                    $(".completedGoalsValDown").addClass("hidden");
                } else if (data['totalCompletedGoals'] < parseInt(completedGoalsNow)) {
                    console.log("lower");
                    valueCompletedGoals = parseInt(completedGoalsNow);
                    newValueCompletedGoals = (data['totalCompletedGoals'] - valueCompletedGoals);
                    $(".completedGoalsValUp").addClass("hidden");
                    $(".completedGoalsValNeutral").addClass("hidden");
                    $(".completedGoalsValDown").removeClass("hidden");
                } else {
                    console.log("neutral");
                    $(".completedGoalsValUp").addClass("hidden");
                    $(".completedGoalsValDown").addClass("hidden");
                    $(".completedGoalsValNeutral").removeClass("hidden");
                    $(".totalCompletedGoals").text(data["totalCompletedGoals"]);
                    $(".completedGoalsNewValue").text("- ");
                }

                if (newValueCompletedGoals != 0) {
                    $(".totalCompletedGoals").text(data["totalCompletedGoals"]);
                    if(newValueTotalTeamChats > 0){
                        $(".completedGoalsNewValue").text("+ " + newValueCompletedGoals);
                    } else {
                        console.log("gfdsa");
                        $(".completedGoalsNewValue").text(newValueCompletedGoals);
                    }
                }
                if (data['totalCompletedGoals'] == 0 && completedGoalsNow == 0) {
                    $(".totalCompletedGoals").text(0);
                    $(".completedGoalsNewValue").text("- ");
                }
            } else {
                $(".totalCompletedGoals").text(data["totalCompletedGoals"]);
                $(".completedGoalsNewValue").text("- ");
                $(".completedGoalsValNeutral").removeClass("hidden");
                $(".completedGoalsValUp").addClass("hidden");
                $(".completedGoalsValDown").addClass("hidden");
            }
            // Total bucketlist goals uncompleted

            var valueCompletedGoals = 0;
            if(unCompletedGoalsNow != 0) {
                if (data['totalUnCompletedGoals'] > parseInt(unCompletedGoalsNow)) {
                    valueCompletedGoals = parseInt(unCompletedGoalsNow);
                    newValueUnCompletedGoals =  data['totalUnCompletedGoals'] - valueCompletedGoals;
                    $(".unCompletedGoalsValUp").removeClass("hidden");
                    $(".unCompletedGoalsValNeutral").addClass("hidden");
                    $(".unCompletedGoalsValDown").addClass("hidden");
                } else if (data['totalUnCompletedGoals'] < parseInt(unCompletedGoalsNow)) {
                    valueCompletedGoals = parseInt(unCompletedGoalsNow);
                    newValueUnCompletedGoals = (data['totalUnCompletedGoals'] - valueCompletedGoals);
                    $(".unCompletedGoalsValUp").addClass("hidden");
                    $(".unCompletedGoalsValNeutral").addClass("hidden");
                    $(".unCompletedGoalsValDown").removeClass("hidden");
                } else {
                    $(".unCompletedGoalsValUp").addClass("hidden");
                    $(".unCompletedGoalsValDown").addClass("hidden");
                    $(".unCompletedGoalsValNeutral").removeClass("hidden");
                    $(".totalUnCompletedGoals").text(data["totalUnCompletedGoals"]);
                    $(".unCompletedGoalsNewValue").text("- ");
                }

                if (newValueUnCompletedGoals != 0) {
                    $(".totalUnCompletedGoals").text(data["totalUnCompletedGoals"]);
                    if(newValueTotalTeamChats > 0){
                        $(".unCompletedGoalsNewValue").text("+ " + newValueUnCompletedGoals);
                    } else {
                        $(".unCompletedGoalsNewValue").text(newValueUnCompletedGoals);
                    }
                }
                if (data['totalUnCompletedGoals'] == 0 && unCompletedGoalsNow == 0) {
                    $(".totalUnCompletedGoals").text(0);
                    $(".unCompletedGoalsNewValue").text("- ");
                }
            } else {
                $(".totalUnCompletedGoals").text(data["totalUnCompletedGoals"]);
                $(".unCompletedGoalsNewValue").text("- ");
                $(".unCompletedGoalsValNeutral").removeClass("hidden");
                $(".unCompletedGoalsValUp").addClass("hidden");
                $(".unCompletedGoalsValDown").addClass("hidden");
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

    $(".bucketlistDashBoardMenu").removeClass("hidden");
    $(".bucketlistDashBoardMenu").toggle();
});

$(".filterBucketlistDashboard").on("click",function () {
    var filter = $(this).data("filter");
    var team_id = $(".team_id").val();
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/workspace/getDashboardFilteredData",
        dataType: "JSON",
        data: {'team_id': team_id, "bucketlist_filter" : filter},
        success: function (data) {
            if(filter == "Total") {
                $(".totalCompletedGoals").text(data['totalCompletedGoals']);
                $(".totalUnCompletedGoals").text(data['totalUnCompletedGoals']);

                $(".completedGoalsValUp").addClass("hidden");
                $(".completedGoalsValDown").addClass("hidden");
                $(".completedGoalsNewValue").text("");
                $(".completedGoalsValNeutral").addClass("hidden");

                $(".unCompletedGoalsValUp").addClass("hidden");
                $(".unCompletedGoalsValDown").addClass("hidden");
                $(".unCompletedGoalsValNeutral").addClass("hidden");
                $(".unCompletedGoalsNewValue").text("");
            }
            if(filter == "Default"){
                getDashboardData();
            }
            if(filter == "Month" || filter == "Week"){
                if(data["completedGoalsAddedValue"] > 0){
                    $(".totalCompletedGoals").text(data["totalCompletedGoalsThisTimespan"]);
                    $(".completedGoalsNewValue").text(data["completedGoalsAddedValue"]);
                    $(".completedGoalsValUp").removeClass("hidden");
                    $(".completedGoalsValDown").addClass("hidden");
                    $(".completedGoalsValNeutral").addClass("hidden");
                } else if(data["completedGoalsAddedValue"] < 0){
                    $(".totalCompletedGoals").text(data["totalCompletedGoalsThisTimespan"]);
                    $(".completedGoalsNewValue").text(data["completedGoalsAddedValue"]);
                    $(".completedGoalsValDown").removeClass("hidden");
                    $(".completedGoalsValUp").addClass("hidden");
                    $(".completedGoalsValNeutral").addClass("hidden");
                } else {
                    $(".totalCompletedGoals").text(data["totalCompletedGoalsThisTimespan"]);
                    $(".completedGoalsNewValue").text(data["completedGoalsAddedValue"]);
                    $(".completedGoalsValNeutral").removeClass("hidden");
                    $(".completedGoalsValUp").addClass("hidden");
                    $(".completedGoalsValDown").addClass("hidden");
                }

                if(data["unCompletedGoalsAddedValue"] > 0){
                    $(".totalUnCompletedGoals").text(data["totalUnCompletedGoalsThisTimespan"]);
                    $(".unCompletedGoalsNewValue").text(data["unCompletedGoalsAddedValue"]);
                    $(".unCompletedGoalsValUp").removeClass("hidden");
                    $(".unCompletedGoalsValDown").addClass("hidden");
                    $(".unCompletedGoalsValNeutral").addClass("hidden");
                } else if(data["unCompletedGoalsAddedValue"] < 0){
                    $(".totalUnCompletedGoals").text(data["totalUnCompletedGoalsThisTimespan"]);
                    $(".unCompletedGoalsNewValue").text(data["unCompletedGoalsAddedValue"]);
                    $(".unCompletedGoalsValDown").removeClass("hidden");
                    $(".unCompletedGoalsValUp").addClass("hidden");
                    $(".unCompletedGoalsValNeutral").addClass("hidden");
                } else {
                    $(".totalUnCompletedGoals").text(data["totalUnCompletedGoalsThisTimespan"]);
                    $(".unCompletedGoalsNewValue").text(data["unCompletedGoalsAddedValue"]);
                    $(".unCompletedGoalsValNeutral").removeClass("hidden");
                    $(".unCompletedGoalsValUp").addClass("hidden");
                    $(".unCompletedGoalsValDown").addClass("hidden");
                }
            }
        }
    });
});

$(".toggleBucketlistMenu").on("click",function () {
    $(".bucketlistDashBoardMenu").toggle();
});


