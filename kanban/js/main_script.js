$(function() {
    $('.sortable.card').dblclick(function() {
      var cardId = $(this).attr("id");
      var cardText = $(this).text();
      var cardColor = $(this).css("background-color");
      var cardNote = $(this).data("note");
      var cardDate = $(this).data("date");

      // Open a dialog for editing card details
      openCardDialog(cardId, cardText, cardColor, cardNote, cardDate);
    });

    $('.todo').sortable({
      connectWith: ['.inProgress', '.done', '.delete'],
      placeholder: 'emptySpace',
      dropOnEmpty: true,
      update: function(event, ui) {
        var cardId = ui.item.attr("id");
        var newStatus = $(this).hasClass('delete') ? 'delete' : 'todo';
        updateCardStatus(cardId, newStatus);
      }
    });

    $('.inProgress').sortable({
      connectWith: ['.todo', '.done', '.delete'],
      placeholder: 'emptySpace',
      dropOnEmpty: true,
      update: function(event, ui) {
        var cardId = ui.item.attr("id");
        var newStatus = $(this).hasClass('delete') ? 'delete' : 'inProgress';
        updateCardStatus(cardId, newStatus);
      }
    });

    $('.done').sortable({
      connectWith: ['.todo', '.inProgress', '.delete'],
      placeholder: 'emptySpace',
      dropOnEmpty: true,
      update: function(event, ui) {
        var cardId = ui.item.attr("id");
        var newStatus = $(this).hasClass('delete') ? 'delete' : 'done';
        updateCardStatus(cardId, newStatus);
      }
    });

    $('.delete').sortable({
      connectWith: ['.todo', '.inProgress', '.done'],
      placeholder: 'emptySpace',
      dropOnEmpty: true,
      update: function(event, ui) {
        var cardId = ui.item.attr("id");
        updateCardStatus(cardId, 'delete');
      }
    });

    $(".addButton").click(function() {
      var itemText = $("#itemText").val().trim();
      if (itemText !== "") {
        var cardId = "card" + Date.now();
        var newItem = $("<div class='sortable card'</div>").attr("id", cardId).text(itemText).css("background-color", "white").data("note", "null").data("date", "null"); ;
        saveCard(cardId, itemText, "todo")
        newItem.sortable();
        newItem.appendTo(".todo");
      }
    });
    $('#logout-btn').click(function() {
    
    window.location.href = '../index.php';
  });
  $('#back-btn').click(function() {
    
    window.location.href = '../project_page.php';
  });
  });

  function openCardDialog(cardId, cardText, cardColor, cardNote, cardDate) {
    // Create a dialog for editing card details
    var dialogContent = `
      <label for="cardText">Текст:</label>
      <input type="text" id="cardText" value="${cardText}">
      <br>
      <label for="cardColor">Цвет:</label>
      <input type="color" id="cardColor" value="${cardColor}">
      <br>
      <label for="cardNote">Пометки:</label>
      <textarea id="cardNote">${cardNote}</textarea>
      <br>
      <label for="cardDate">К дате:</label>
      <input type="date" id="cardDate" value="${cardDate}">
    `;

    $("<div></div>").html(dialogContent).dialog({
      modal: true,
      title: "Edit Card",
      buttons: {
        "Save": function() {
          var newText = $("#cardText").val().trim();
          var newColor = $("#cardColor").val();
          var newNote = $("#cardNote").val().trim();
          var newDate = $("#cardDate").val();

          $("#" + cardId).text(newText).css("background-color", newColor).data("note", newNote).data("date", newDate);
          updateCardDetails(cardId, newText, newColor, newNote, newDate);
          $(this).dialog("close");
        },
        "Cancel": function() {
          $(this).dialog("close");
        }
      }
    });
  }

  function saveCard(cardId, cardText, status) {
    $.ajax({
      url: "../php/save_card.php",
      method: "POST",
      data: {
        cardId: cardId,
        cardText: cardText,
        status: status
      },
      success: function(response) {
        console.log("Card saved successfully.");
      },
      error: function(xhr, status, error) {
        console.error("Error saving card:", error);
      }
    });
  }

  function updateCardStatus(cardId, status) {
    $.ajax({
      url: "../php/update_card_status.php",
      method: "POST",
      data: {
        cardId: cardId,
        status: status
      },
      success: function(response) {
        console.log("Card status updated successfully.");
      },
      error: function(xhr, status, error) {
        console.error("Error updating card status:", error);
      }
    });
  }

  function updateCardDetails(cardId, cardText, cardColor, cardNote, cardDate) {
    $.ajax({
      url: "../php/update_card_details.php",
      method: "POST",
      data: {
        cardId: cardId,
        cardText: cardText,
        cardColor: cardColor,
        cardNote: cardNote,
        cardDate: cardDate
      },
      success: function(response) {
        console.log("Card details updated successfully.");
      },
      error: function(xhr, status, error) {
        console.error("Error updating card details:", error);
      }
    });
  }