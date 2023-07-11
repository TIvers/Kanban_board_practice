$(document).ready(function() {
  $(".addButton").click(function() {
    var board_name = $("#board_name").val().trim();
    if (board_name !== "") {
      var cardId = "card" + Date.now();
      saveCard(cardId, "Ваш базовый элемент", "todo", board_name);
    }
  });
  $('#logout-btn').click(function() {

window.location.href = '../index.php';
});
  function saveCard(cardId, cardText, status, board_name) {
    $.ajax({
      url: "../php/save_card.php",
      method: "POST",
      data: {
        cardId: cardId,
        cardText: cardText,
        status: status,
        board_name: board_name
      },
      success: function(response) {
        console.log("Card saved successfully.");
        location.reload();
      },
      error: function(xhr, status, error) {
        console.error("Error saving card:", error);
      }
    });
  }
});

