$(document).ready(function() {
    $(".mostTicketsCategory").text("Week");
    getDashboardData();
    getDashboardDataShortTermPlannerTasks();
    setInterval(function () {
        getDashboardData();
        getDashboardDataShortTermPlannerTasks();
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

    var totalIdeasNow = $(".totalIdeas24Hours").val();
    var newValueTotalIdeas = 0;

    var totalIdeasOnHoldNow = $(".totalIdeasOnHold24Hours").val();
    var newValueTotalIdeasOnHold = 0;

    var totalIdeasPassedNow = $(".totalIdeasPassed24Hours").val();
    var newValueTotalIdeasPassed = 0;

    var totalIdeasRejectedNow = $(".totalIdeasRejected24Hours").val();
    var newValueTotalIdeasRejected = 0;
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
                if(newValueTotalTeamChats >= 0){
                    $(".totalTeamChatsNewValue").text("+ " + newValueTotalTeamChats);
                } else {
                    $(".totalTeamChatsNewValue").text(newValueTotalTeamChats);
                }
            }
            if (data['totalTeamChats'] == 0 && totalTeamChatsNow == 0) {
                $(".totalTeamChats").text(0);
                $(".totalTeamChatsNewValue").text("- ");
            }

            //Total assistance tickets
            var valueTotalAssistanceTickets = 0;
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
                if(newValueTotalAssistanceTickets >= 0){
                    $(".totalAssistanceTicketsNewValue").text("+ " + newValueTotalAssistanceTickets);
                } else {
                    $(".totalAssistanceTicketsNewValue").text(newValueTotalAssistanceTickets);
                }
            }
            if (data['totalAssistanceTickets'] == 0 && totalAssistanceTicketsNow == 0) {
                $(".totalAssistanceTickets").text(0);
                $(".totalAssistanceTicketsNewValue").text("- ");
            }

            //Total assistanceTickets completed
            var valueTotalAssistanceTicketsCompleted = 0;
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
                if(newValueTotalAssistanceTicketsCompleted >= 0){
                    $(".totalAssistanceTicketsCompletedNewValue").text("+ " + newValueTotalAssistanceTicketsCompleted);
                } else {
                    $(".totalAssistanceTicketsCompletedNewValue").text(newValueTotalAssistanceTicketsCompleted);
                }
            }
            if (data['totalAssistanceTicketsCompleted'] == 0 && newValueTotalAssistanceTicketsCompleted == 0) {
                $(".totalAssistanceTicketsCompleted").text(0);
                $(".totalAssistanceTicketsCompletedNewValue").text("- ");
            }

            // Total bucketlist goals completed
            var valueCompletedGoals = 0;
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
                if(newValueTotalTeamChats >= 0){
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
            // Total bucketlist goals uncompleted

            var valueCompletedGoals = 0;
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
                    if(newValueTotalTeamChats >= 0){
                        $(".unCompletedGoalsNewValue").text("+ " + newValueUnCompletedGoals);
                    } else {
                        $(".unCompletedGoalsNewValue").text(newValueUnCompletedGoals);
                    }
                }
                if (data['totalUnCompletedGoals'] == 0 && unCompletedGoalsNow == 0) {
                    $(".totalUnCompletedGoals").text(0);
                    $(".unCompletedGoalsNewValue").text("- ");
                }

            // Total ideas
            var valueIdeas = 0;
            if (data['totalIdeas'] > parseInt(totalIdeasNow)) {
                valueIdeas = parseInt(unCompletedGoalsNow);
                newValueTotalIdeas =  data['totalIdeas'] - valueIdeas;
                $(".totalIdeasValUp").removeClass("hidden");
                $(".totalIdeasValNeutral").addClass("hidden");
                $(".totalIdeasValDown").addClass("hidden");
            } else if (data['totalIdeas'] < parseInt(totalIdeasNow)) {
                valueIdeas = parseInt(totalIdeasNow);
                newValueTotalIdeas = (data['totalIdeas'] - valueIdeas);
                $(".totalIdeasValUp").addClass("hidden");
                $(".totalIdeasValNeutral").addClass("hidden");
                $(".totalIdeasValDown").removeClass("hidden");
            } else {
                $(".totalIdeasValUp").addClass("hidden");
                $(".totalIdeasValDown").addClass("hidden");
                $(".totalIdeasValNeutral").removeClass("hidden");
                $(".totalIdeas").text(data["totalIdeas"]);
                $(".totalIdeasNewValue").text("- ");
            }

            if (newValueTotalIdeas != 0) {
                $(".totalIdeas").text(data["totalIdeas"]);
                if(newValueTotalTeamChats >= 0){
                    $(".totalIdeasNewValue").text("+ " + newValueTotalIdeas);
                } else {
                    $(".totalIdeasNewValue").text(newValueTotalIdeas);
                }
            }
            if (data['totalIdeas'] == 0 && totalIdeasNow == 0) {
                $(".totalIdeas").text(0);
                $(".totalIdeasNewValue").text("- ");
            }

            // Total ideas On hold
            var valueIdeasOnHold = 0;
            if (data['totalIdeasOnHold'] > parseInt(totalIdeasOnHoldNow)) {
                valueIdeasOnHold = parseInt(totalIdeasOnHoldNow);
                newValueTotalIdeasOnHold =  data['totalIdeasOnHold'] - valueIdeasOnHold;
                $(".totalIdeasOnHoldValUp").removeClass("hidden");
                $(".totalIdeasOnHoldValNeutral").addClass("hidden");
                $(".totalIdeasOnHoldValDown").addClass("hidden");
            } else if (data['totalIdeasOnHold'] < parseInt(totalIdeasOnHoldNow)) {
                valueIdeasOnHold = parseInt(totalIdeasOnHoldNow);
                newValueTotalIdeasOnHold = (data['totalIdeasOnHold'] - valueIdeasOnHold);
                $(".totalIdeasOnHoldValUp").addClass("hidden");
                $(".totalIdeasOnHoldNeutral").addClass("hidden");
                $(".totalIdeasOnHoldValDown").removeClass("hidden");
            } else {
                $(".totalIdeasOnHoldValUp").addClass("hidden");
                $(".totalIdeasOnHoldValDown").addClass("hidden");
                $(".totalIdeasOnHoldValNeutral").removeClass("hidden");
                $(".totalIdeasOnHold").text(data["totalIdeasOnHold"]);
                $(".totalIdeasOnHoldNewValue").text("- ");
            }

            if (newValueTotalIdeasOnHold != 0) {
                $(".totalIdeasOnHold").text(data["totalIdeasOnHold"]);
                if(newValueTotalIdeasOnHold >= 0){
                    $(".totalIdeasOnHoldNewValue").text("+ " + newValueTotalIdeasOnHold);
                } else {
                    $(".totalIdeasOnHoldNewValue").text(newValueTotalIdeasOnHold);
                }
            }
            if (data['totalIdeasOnHold'] == 0 && totalIdeasOnHoldNow == 0) {
                $(".totalIdeasOnHold").text(0);
                $(".totalIdeasOnHoldNewValue").text("- ");
            }
            // Total ideas Passed
            var valueIdeasPassed = 0;
            if (data['totalIdeasPassed'] > parseInt(totalIdeasPassedNow)) {
                valueIdeasPassed = parseInt(totalIdeasPassedNow);
                newValueTotalIdeasPassed =  data['totalIdeasPassed'] - valueIdeasPassed;
                $(".totalIdeasPassedValUp").removeClass("hidden");
                $(".totalIdeasPassedValNeutral").addClass("hidden");
                $(".totalIdeasPassedValDown").addClass("hidden");
            } else if (data['totalIdeasPassed'] < parseInt(totalIdeasPassedNow)) {
                valueIdeasPassed = parseInt(totalIdeasPassedNow);
                newValueTotalIdeasPassed = (data['totalIdeasPassed'] - valueIdeasPassed);
                $(".totalIdeasPassedValUp").addClass("hidden");
                $(".totalIdeasPassedNeutral").addClass("hidden");
                $(".totalIdeasPassedValDown").removeClass("hidden");
            } else {
                $(".totalIdeasPassedValUp").addClass("hidden");
                $(".totalIdeasPassedValDown").addClass("hidden");
                $(".totalIdeasPassedValNeutral").removeClass("hidden");
                $(".totalIdeasPassed").text(data["totalIdeasPassed"]);
                $(".totalIdeasPassedNewValue").text("- ");
            }

            if (newValueTotalIdeasPassed != 0) {
                $(".totalIdeasPassed").text(data["totalIdeasPassed"]);
                if(newValueTotalIdeasPassed >= 0){
                    $(".totalIdeasPassedNewValue").text("+ " + newValueTotalIdeasPassed);
                } else {
                    $(".totalIdeasPassedNewValue").text(newValueTotalIdeasPassed);
                }
            }
            if (data['totalIdeasPassed'] == 0 && totalIdeasPassedNow == 0) {
                $(".totalIdeasPassed").text(0);
                $(".totalIdeasPassedNewValue").text("- ");
            }

            // Total ideas Rejected
            var valueIdeasRejected = 0;
            if (data['totalIdeasRejected'] > parseInt(totalIdeasRejectedNow)) {
                valueIdeasRejected = parseInt(totalIdeasRejectedNow);
                newValueTotalIdeasRejected =  data['totalIdeasRejected'] - valueIdeasRejected;
                $(".totalIdeasRejectedValUp").removeClass("hidden");
                $(".totalIdeasRejectedValNeutral").addClass("hidden");
                $(".totalIdeasRejectedValDown").addClass("hidden");
            } else if (data['totalIdeasRejected'] < parseInt(totalIdeasRejectedNow)) {
                valueIdeasRejected = parseInt(totalIdeasRejectedNow);
                newValueTotalIdeasRejected = (data['totalIdeasRejected'] - valueIdeasRejected);
                $(".totalIdeasRejectedValUp").addClass("hidden");
                $(".totalIdeasRejectedNeutral").addClass("hidden");
                $(".totalIdeasRejectedValDown").removeClass("hidden");
            } else {
                $(".totalIdeasRejectedValUp").addClass("hidden");
                $(".totalIdeasRejectedValDown").addClass("hidden");
                $(".totalIdeasRejectedValNeutral").removeClass("hidden");
                $(".totalIdeasRejected").text(data["totalIdeasRejected"]);
                $(".totalIdeasRejectedNewValue").text("- ");
            }

            if (newValueTotalIdeasRejected != 0) {
                $(".totalIdeasRejected").text(data["totalIdeasRejected"]);
                if(newValueTotalIdeasRejected >= 0){
                    $(".totalIdeasRejectedNewValue").text("+ " + newValueTotalIdeasRejected);
                } else {
                    $(".totalIdeasRejectedNewValue").text(newValueTotalIdeasRejected);
                }
            }
            if (data['totalIdeasRejected'] == 0 && totalIdeasRejectedNow == 0) {
                $(".totalIdeasRejected").text(0);
                $(".totalIdeasRejectedNewValue").text("- ");
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

// ==============================

function getDashboardDataShortTermPlannerTasks() {
    var team_id = $(".team_id").val();
    var user_id = $(".user_id").val();

    var totalTasksCreatedNow = $(".totalTasksCreated24Hours").val();
    var newValueTotalTasksCreated = 0;

    var totalTasksCompletedNow = $(".totalTasksCompleted24Hours").val();
    var newValueTotalTasksCompleted = 0;

    var totalTasksToDoNow = $(".totalTasksToDo24Hours").val();
    var newValueTotalTasksToDo = 0;

    var totalTasksExpiredDueDateNow = $(".totalTasksExpiredDueDate24Hours").val();
    var newValueTotalTasksExpiredDueDate = 0;
    $.ajax({
        method: "POST",
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        url: "/workspace/getRealtimeDataDashboardShortTermPlannerTasks",
        dataType: "JSON",
        data: {'user_id': user_id, 'team_id': team_id},
        success: function (data) {
            // short term planner tasks dashboard
            var valueTasksCreated = 0;
            if (data['totalTasksCreated'] > parseInt(totalTasksCreatedNow)) {
                valueTasksCreated = parseInt(totalTasksCreatedNow);
                newValueTotalTasksCreated =  data['totalTasksCreated'] - valueTasksCreated;
                $(".totalTasksCreatedValUp").removeClass("hidden");
                $(".totalTasksCreatedValNeutral").addClass("hidden");
                $(".totalTasksCreatedValDown").addClass("hidden");
            } else if (data['totalTasksCreated'] < parseInt(totalTasksCreatedNow)) {
                valueTasksCreated = parseInt(totalTasksCreatedNow);
                newValueTotalTasksCreated = (data['totalTasksCreated'] - valueTasksCreated);
                $(".totalTasksCreatedValUp").addClass("hidden");
                $(".totalTasksCreatedNeutral").addClass("hidden");
                $(".totalTasksCreatedValDown").removeClass("hidden");
            } else {
                $(".totalTasksCreatedValUp").addClass("hidden");
                $(".totalTasksCreatedValDown").addClass("hidden");
                $(".totalTasksCreatedValNeutral").removeClass("hidden");
                $(".totalTasksCreated").text(data["totalTasksCreated"]);
                $(".totalTasksCreatedNewValue").text("- ");
            }

            if (newValueTotalTasksCreated != 0) {
                $(".totalTasksCreated").text(data["totalTasksCreated"]);
                if(newValueTotalTasksCreated >= 0){
                    $(".totalTasksCreatedNewValue").text("+ " + newValueTotalTasksCreated);
                } else {
                    $(".totalTasksCreatedNewValue").text(newValueTotalTasksCreated);
                }
            }
            if (data['totalTasksCreated'] == 0 && totalTasksCreatedNow == 0) {
                $(".totalIdeasRejected").text(0);
                $(".totalIdeasRejectedNewValue").text("- ");
            }

            var valueTasksCompleted = 0;
            if (data['totalTasksCompleted'] > parseInt(totalTasksCompletedNow)) {
                newValueTotalTasksCompleted = parseInt(totalTasksCompletedNow);
                newValueTotalTasksCompleted =  data['totalTasksCompleted'] - valueTasksCompleted;
                $(".totalTasksCompletedValUp").removeClass("hidden");
                $(".totalTasksCompletedValNeutral").addClass("hidden");
                $(".totalTasksCompletedValDown").addClass("hidden");
            } else if (data['totalTasksCompleted'] < parseInt(totalTasksCompletedNow)) {
                valueTasksCompleted = parseInt(totalTasksCompletedNow);
                newValueTotalTasksCompleted = (data['totalTasksCompleted'] - valueTasksCompleted);
                $(".totalTasksCompletedValUp").addClass("hidden");
                $(".totalTasksCompletedNeutral").addClass("hidden");
                $(".totalTasksCompletedValDown").removeClass("hidden");
            } else {
                $(".totalTasksCompletedValUp").addClass("hidden");
                $(".totalTasksCompletedValDown").addClass("hidden");
                $(".totalTasksCompletedValNeutral").removeClass("hidden");
                $(".totalTasksCompleted").text(data["totalTasksCompleted"]);
                $(".totalTasksCompletedNewValue").text("- ");
            }

            if (newValueTotalTasksCompleted != 0) {
                $(".totalTasksCompleted").text(data["totalTasksCompleted"]);
                if(newValueTotalTasksCreated >= 0){
                    $(".totalTasksCompletedNewValue").text("+ " + newValueTotalTasksCompleted);
                } else {
                    $(".totalTasksCompletedNewValue").text(newValueTotalTasksCompleted);
                }
            }
            if (data['totalTasksCompleted'] == 0 && totalTasksCompletedNow == 0) {
                $(".totalTasksCompleted").text(0);
                $(".totalTasksCompletedNewValue").text("- ");
            }
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

    $(".chatsAssistanceDashBoardMenu").removeClass("hidden");
    $(".chatsAssistanceDashBoardMenu").toggle();

    $(".ideasDashBoardMenu").removeClass("hidden");
    $(".ideasDashBoardMenu").toggle();

    $(".shortTermPlannerDashboardMenu").removeClass("hidden");
    $(".shortTermPlannerDashboardMenu").toggle();
});

$(".filterBucketlistDashboard").on("click",function () {
    var filter = $(this).data("filter");
    var team_id = $(".team_id").val();
    var dashboardCategory = "Bucketlist";
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
        data: {'team_id': team_id, "bucketlist_filter" : filter, 'dashboardCategory': dashboardCategory},
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

$(".toggleChatsAssistanceMenu").on("click",function () {
   $(".chatsAssistanceDashBoardMenu").toggle();
});

$(".toggleIdeasMenu").on("click",function () {
    $(".ideasDashBoardMenu").toggle();
});

$(".toggleShortTermPlannerDashboardMenu").on("click",function () {
    $(".shortTermPlannerDashboardMenu").toggle();
});

$(".filterChatsAssistanceDashBoard").on("click",function () {
    var filter = $(this).data("filter");
    var team_id = $(".team_id").val();
    var dashboardCategory = "chatsAssistance";
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
        data: {'team_id': team_id, "bucketlist_filter" : filter, 'dashboardCategory': dashboardCategory},
        success: function (data) {
            if(filter == "Total") {
                $(".totalTeamChats").text(data['totalTeamChats']);
                $(".totalAssistanceTickets").text(data['totalAssistanceTickets']);
                $(".totalAssistanceTicketsCompleted").text(data['totalAssistanceTicketsCompleted']);

                $(".totalTeamChatsValUp").addClass("hidden");
                $(".totalTeamChatsValDown").addClass("hidden");
                $(".totalTeamChatsNewValue").text("");
                $(".totalTeamChatsValNeutral").addClass("hidden");

                $(".totalAssistanceTicketsValUp").addClass("hidden");
                $(".totalAssistanceTicketsValDown").addClass("hidden");
                $(".totalAssistanceTicketsValNeutral").addClass("hidden");
                $(".totalAssistanceTicketsNewValue").text("");

                $(".totalAssistanceTicketsCompletedValUp").addClass("hidden");
                $(".totalAssistanceTicketsCompletedValDown").addClass("hidden");
                $(".totalAssistanceTicketsCompletedValNeutral").addClass("hidden");
                $(".totalAssistanceTicketsCompletedNewValue").text("");
            }
            if(filter == "Default"){
                getDashboardData();
            }
            if(filter == "Month" || filter == "Week"){
                if(data["teamChatsAddedValue"] > 0){
                    $(".totalTeamChats").text(data["totalTeamChatsThisTimespan"]);
                    $(".totalTeamChatsNewValue").text("+ " + data["teamChatsAddedValue"]);
                    $(".totalTeamChatsValUp").removeClass("hidden");
                    $(".totalTeamChatsValDown").addClass("hidden");
                    $(".totalTeamChatsValNeutral").addClass("hidden");
                } else if(data["teamChatsAddedValue"] < 0){
                    $(".totalTeamChats").text(data["totalTeamChatsThisTimespan"]);
                    $(".totalTeamChatsNewValue").text(data["teamChatsAddedValue"]);
                    $(".totalTeamChatsValDown").removeClass("hidden");
                    $(".totalTeamChatsValUp").addClass("hidden");
                    $(".totalTeamChatsValNeutral").addClass("hidden");
                } else {
                    $(".totalTeamChats").text(data["totalTeamChatsThisTimespan"]);
                    $(".totalTeamChatsNewValue").text(data["teamChatsAddedValue"]);
                    $(".totalTeamChatsValNeutral").removeClass("hidden");
                    $(".totalTeamChatsValUp").addClass("hidden");
                    $(".totalTeamChatsValDown").addClass("hidden");
                }

                if(data["assistanceTicketsAddedValue"] > 0){
                    $(".totalAssistanceTickets").text(data["totalAssistanceTicketsThisTimespan"]);
                    $(".totalAssistanceTicketsNewValue").text("+ " + data["assistanceTicketsAddedValue"]);
                    $(".totalAssistanceTicketsValUp").removeClass("hidden");
                    $(".totalAssistanceTicketsValDown").addClass("hidden");
                    $(".totalAssistanceTicketsValNeutral").addClass("hidden");
                } else if(data["assistanceTicketsAddedValue"] < 0){
                    $(".totalAssistanceTickets").text(data["totalAssistanceTicketsThisTimespan"]);
                    $(".totalAssistanceTicketsNewValue").text(data["assistanceTicketsAddedValue"]);
                    $(".totalAssistanceTicketsValDown").removeClass("hidden");
                    $(".totalAssistanceTicketsValUp").addClass("hidden");
                    $(".totalAssistanceTicketsValNeutral").addClass("hidden");
                } else {
                    $(".totalAssistanceTickets").text(data["totalAssistanceTicketsThisTimespan"]);
                    $(".totalAssistanceTicketsNewValue").text(data["assistanceTicketsAddedValue"]);
                    $(".totalAssistanceTicketsValNeutral").removeClass("hidden");
                    $(".totalAssistanceTicketsValUp").addClass("hidden");
                    $(".totalAssistanceTicketsValDown").addClass("hidden");
                }

                if(data["assistanceTicketsCompletedAddedValue"] > 0){
                    $(".totalAssistanceTicketsCompleted").text(data["totalAssistanceTicketsCompletedThisTimespan"]);
                    $(".totalAssistanceTicketsCompletedNewValue").text("+ " + data["assistanceTicketsCompletedAddedValue"]);
                    $(".totalAssistanceTicketsCompletedValUp").removeClass("hidden");
                    $(".totalAssistanceTicketsCompletedValDown").addClass("hidden");
                    $(".totalAssistanceTicketsCompletedValNeutral").addClass("hidden");
                } else if(data["assistanceTicketsCompletedAddedValue"] < 0){
                    $(".totalAssistanceTicketsCompleted").text(data["totalAssistanceTicketsCompletedThisTimespan"]);
                    $(".totalAssistanceTicketsCompletedNewValue").text(data["assistanceTicketsCompletedAddedValue"]);
                    $(".totalAssistanceTicketsCompletedValDown").removeClass("hidden");
                    $(".totalAssistanceTicketsCompletedValUp").addClass("hidden");
                    $(".totalAssistanceTicketsCompletedValNeutral").addClass("hidden");
                } else {
                    $(".totalAssistanceTicketsCompleted").text(data["totalAssistanceTicketsCompletedThisTimespan"]);
                    $(".totalAssistanceTicketsCompletedNewValue").text(data["assistanceTicketsCompletedAddedValue"]);
                    $(".totalAssistanceTicketsCompletedValNeutral").removeClass("hidden");
                    $(".totalAssistanceTicketsCompletedValUp").addClass("hidden");
                    $(".totalAssistanceTicketsCompletedValDown").addClass("hidden");
                }
            }
        }
    });
});

$(".filterIdeasDashboard").on("click",function () {
    var filter = $(this).data("filter");
    var team_id = $(".team_id").val();
    var dashboardCategory = "Ideas";
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
        data: {'team_id': team_id, "bucketlist_filter" : filter, 'dashboardCategory': dashboardCategory},
        success: function (data) {
            if(filter == "Total") {
                $(".totalIdeas").text(data['totalIdeas']);
                $(".totalIdeasOnHold").text(data['totalIdeasOnHold']);
                $(".totalIdeasPassed").text(data['totalIdeasPassed']);
                $(".totalIdeasRejected").text(data['totalIdeasRejected']);

                $(".totalIdeasValUp").addClass("hidden");
                $(".totalIdeasValDown").addClass("hidden");
                $(".totalIdeasNewValue").text("");
                $(".totalIdeasValNeutral").addClass("hidden");

                $(".totalIdeasOnHoldValUp").addClass("hidden");
                $(".totalIdeasOnHoldValDown").addClass("hidden");
                $(".totalIdeasOnHoldValNeutral").addClass("hidden");
                $(".totalIdeasOnHoldNewValue").text("");

                $(".totalIdeasPassedValUp").addClass("hidden");
                $(".totalIdeasPassedValDown").addClass("hidden");
                $(".totalIdeasPassedValNeutral").addClass("hidden");
                $(".totalIdeasPassedNewValue").text("");

                $(".totalIdeasRejectedValUp").addClass("hidden");
                $(".totalIdeasRejectedValDown").addClass("hidden");
                $(".totalIdeasRejectedValNeutral").addClass("hidden");
                $(".totalIdeasRejectedNewValue").text("");
            }
            if(filter == "Default"){
                getDashboardData();
            }
            if(filter == "Month" || filter == "Week"){
                if(data["ideasAddedValue"] > 0){
                    $(".totalIdeas").text(data["totalIdeasThisTimespan"]);
                    $(".totalIdeasNewValue").text("+ " + data["ideasAddedValue"]);
                    $(".totalIdeasValUp").removeClass("hidden");
                    $(".totalIdeasValDown").addClass("hidden");
                    $(".totalIdeasValNeutral").addClass("hidden");
                } else if(data["ideasAddedValue"] < 0){
                    $(".totalIdeas").text(data["totalIdeasThisTimespan"]);
                    $(".totalIdeasNewValue").text(data["ideasAddedValue"]);
                    $(".totalIdeasValDown").removeClass("hidden");
                    $(".totalIdeasValUp").addClass("hidden");
                    $(".totalIdeasValNeutral").addClass("hidden");
                } else {
                    $(".totalIdeas").text(data["totalIdeasThisTimespan"]);
                    $(".totalIdeasNewValue").text(data["ideasAddedValue"]);
                    $(".totalIdeasValNeutral").removeClass("hidden");
                    $(".totalIdeasValUp").addClass("hidden");
                    $(".totalIdeasValDown").addClass("hidden");
                }

                if(data["ideasOnHoldAddedValue"] > 0){
                    $(".totalIdeasOnHold").text(data["totalIdeasOnHoldThisTimespan"]);
                    $(".totalIdeasOnHoldNewValue").text("+ " + data["ideasOnHoldAddedValue"]);
                    $(".totalIdeasOnHoldValUp").removeClass("hidden");
                    $(".totalIdeasOnHoldValDown").addClass("hidden");
                    $(".totalIdeasOnHoldValNeutral").addClass("hidden");
                } else if(data["ideasOnHoldAddedValue"] < 0){
                    $(".totalIdeasOnHold").text(data["totalIdeasOnHoldThisTimespan"]);
                    $(".totalIdeasOnHoldNewValue").text(data["ideasOnHoldAddedValue"]);
                    $(".totalIdeasOnHoldValDown").removeClass("hidden");
                    $(".totalIdeasOnHoldValUp").addClass("hidden");
                    $(".totalIdeasOnHoldValNeutral").addClass("hidden");
                } else {
                    $(".totalIdeasOnHold").text(data["totalIdeasOnHoldThisTimespan"]);
                    $(".totalIdeasOnHoldNewValue").text(data["ideasOnHoldAddedValue"]);
                    $(".totalIdeasOnHoldValNeutral").removeClass("hidden");
                    $(".totalIdeasOnHoldValUp").addClass("hidden");
                    $(".totalIdeasOnHoldValDown").addClass("hidden");
                }

                if(data["ideasPassedAddedValue"] > 0){
                    $(".totalIdeasPassed").text(data["totalIdeasPassedThisTimespan"]);
                    $(".totalIdeasPassedNewValue").text("+ " + data["ideasPassedAddedValue"]);
                    $(".totalIdeasPassedValUp").removeClass("hidden");
                    $(".totalIdeasPassedValDown").addClass("hidden");
                    $(".totalIdeasPassedValNeutral").addClass("hidden");
                } else if(data["ideasPassedAddedValue"] < 0){
                    $(".totalIdeasPassed").text(data["totalIdeasPassedThisTimespan"]);
                    $(".totalIdeasPassedNewValue").text(data["ideasPassedAddedValue"]);
                    $(".totalIdeasPassedValDown").removeClass("hidden");
                    $(".totalIdeasPassedValUp").addClass("hidden");
                    $(".totalIdeasPassedValNeutral").addClass("hidden");
                } else {
                    $(".totalIdeasPassed").text(data["totalIdeasPassedThisTimespan"]);
                    $(".totalIdeasPassedNewValue").text(data["ideasPassedAddedValue"]);
                    $(".totalIdeasPassedValNeutral").removeClass("hidden");
                    $(".totalIdeasPassedValUp").addClass("hidden");
                    $(".totalIdeasPassedValDown").addClass("hidden");
                }

                if(data["ideasRejectedAddedValue"] > 0){
                    $(".totalIdeasRejected").text(data["totalIdeasRejectedThisTimespan"]);
                    $(".totalIdeasRejectedNewValue").text("+ " + data["ideasRejectedAddedValue"]);
                    $(".totalIdeasRejectedValUp").removeClass("hidden");
                    $(".totalIdeasRejectedValDown").addClass("hidden");
                    $(".totalIdeasRejectedValNeutral").addClass("hidden");
                } else if(data["ideasRejectedAddedValue"] < 0){
                    $(".totalIdeasRejected").text(data["totalIdeasRejectedThisTimespan"]);
                    $(".totalIdeasRejectedNewValue").text(data["ideasRejectedAddedValue"]);
                    $(".totalIdeasRejectedValDown").removeClass("hidden");
                    $(".totalIdeasRejectedValUp").addClass("hidden");
                    $(".totalIdeasRejectedValNeutral").addClass("hidden");
                } else {
                    $(".totalIdeasRejected").text(data["totalIdeasRejectedThisTimespan"]);
                    $(".totalIdeasRejectedNewValue").text(data["ideasRejectedAddedValue"]);
                    $(".totalIdeasRejectedValNeutral").removeClass("hidden");
                    $(".totalIdeasRejectedValUp").addClass("hidden");
                    $(".totalIdeasRejectedValDown").addClass("hidden");
                }
            }
        }
    });
});
