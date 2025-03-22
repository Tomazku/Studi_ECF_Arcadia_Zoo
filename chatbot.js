function toggleChat() {
    let chatBody = document.getElementById("chat-body");
    chatBody.style.display = chatBody.style.display === "block" ? "none" : "block";
}

function sendMessage() {
    let userInput = document.getElementById("user-input").value;
    if (userInput.trim() === "") return;

    let chatBox = document.getElementById("chat-box");
    chatBox.innerHTML += `<p><strong>Vous:</strong> ${userInput}</p>`;
    document.getElementById("user-input").value = "";

    fetch("chatbot.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ message: userInput })
    })
        .then(response => response.json())
        .then(data => {
            let botMessage = data.choices ? data.choices[0].message.content : "Erreur dans la réponse.";
            chatBox.innerHTML += `<p><strong>Bot:</strong> ${botMessage}</p>`;
            chatBox.scrollTop = chatBox.scrollHeight;
        })
        .catch(error => console.error("Erreur:", error));
}

function handleKeyPress(event) {
    if (event.key === "Enter") {
        sendMessage();
    }
}
