<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Online Quiz</title>
  <style>
    .container {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 50vh;
    }
    .newcontainer {
      display: flex;
      flex-direction: column;
      align-items: center; /* Center the entire container horizontally */
      justify-content: flex-start;
      padding: 10px;
    }

    .newcontainer .row1 {
      display: flex;
      flex-direction: row;
      align-items: center;
      justify-content: space-between;
      width: fit-content; /* The row will only take as much space as needed */
     
      padding: 10px;
     
      border-radius: 5px;
    }

    .number-box {
      margin: 0 550px; /* Adds space between boxes */
      text-align: center; /* Centers content within the box */
    }

    .qnumber-container,
    .timer-container {
      width: auto; 
      padding: 5px 10px;
    }
    .row {
      display: flex;
      gap: 80px;
      margin-bottom: 20px;
    }
    .box {
      width: 350px;
      height: 80px;
      background-color: rgb(43, 93, 158);
      display: flex;
      align-items: center;
      justify-content: center;
      border: 1px solid #ccc;
      border-radius: 15px;
      color: white;
      cursor: pointer;
    }
    .question-container {
      margin: 10px 0;
      width: 500px;
      height: 80px;
      background-color: rgb(43, 93, 158);
      display: flex;
      align-items: center !important;
      justify-content: center;
      border: 1px solid #ccc;
      border-radius: 15px;
      color: white;
      cursor: pointer;
    }
    .options {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      justify-content: center;
    }
    
    .option {
      padding: 10px;
      background-color: rgb(43, 93, 158);
      border: 1px solid #6985aa;
      border-radius: 10px;
      width: 300px;
      text-align: center;
      cursor: pointer;
      color: rgb(228, 224, 224) !important;
    }
    .option:hover {
      background-color: rgb(161, 150, 150);
    }
    .hidden {
      display: none;
    }
    .number-box {
    width: 50px;
    height: 50px;
    border: 1px solid #ccc;
    border-radius: 15px;
    color: white;
    display: flex;
    align-items: center; 
    justify-content: center;
    background-color: #f00; 
  }

  .qnumber-container {
    background-color: #f00;
    width: 20px; 
    height: 20px; 
    display: flex; 
    align-items: left;
    justify-content: left;
    color: white;
    font-size: 12px;
    border-radius: 50%;
  }
    #options-container {
      display: grid;
      grid-template-columns: repeat(2, 1fr); 
      gap: 10px; 
      width: fit-content;
      border-radius: 30%; 
    }
    #result-text {
      margin: 10px 0;
      width: 250px;
      height: 80px;
      background-color: rgb(43, 93, 158);
      display: flex;
      align-items: center !important;
      justify-content: center;
      border: 1px solid #ccc;
      border-radius: 15px;
      color: white;
      cursor: pointer;
    }
    
    .correct-question-box {
      margin: 10px 0;
      width: 250px;
      height: 80px;
      background-color: rgb(43, 93, 158);
      display: flex;
      align-items: center;
      justify-content: center;
      border: 1px solid #ccc;
      border-radius: 15px;
      color: white;
      cursor: pointer;
      gap: 10px !important; 
    }
    .correct-answer-box {
      margin: 10px 0;
      width: 250px;
      height: 80px;
      background-color: rgb(43, 93, 158);
      display: flex;
      align-items: center;
      justify-content: center;
      border: 1px solid #ccc;
      border-radius: 15px;
      color: white;
      cursor: pointer;
      gap: 10px !important; 
    }
    .row-container {
        display: flex;
        justify-content: space-between; 
        gap: 20px;
    }

    .color_box{
      width: 100px;
      height: 50px;
      background-color: rgb(43, 93, 158);
      display: flex;
      align-items: center;
      justify-content: center;
      border: 1px solid #ccc;
      border-radius: 15px;
      color: white;
      cursor: pointer;
    }


  </style>
</head>
<body style="background-color: rgb(167, 52, 161)">
  
  <div class="container" id="category_container"><h3>Online Quiz Select Quiz Type</h3></div>
 
  
  <div class="newcontainer hidden" id="smallbox_container">
    <div class="row1">
      <div class="number-box" align="left">
        <div class="qnumber-container" id="question_number"></div>
      </div>
      <div  class="number-box" align="right">
        <div class="timer-container" id="timer_q"></div>
      </div>
    </div>
  </div>
    <div class="container hidden" id="quiz-container">
     
      <div class="question-container" id="question_text"></div>
      <div class="options" id="options-container"></div><br>
      <button class="color_box" onclick="nextQuestion()">Next</button>
    </div>
  </div>
 

  <div class="container hidden" id="result-container">
 
   
    <div class="row-container">
    <ul id="correct-question-list"></ul>
    <ul id="correct-answer-list"></ul>
    </div>

    <p id="result-text"></p>

    <button class="color_box" onclick="restartQuiz()">Restart</button>
  </div>

  <script>
    let allQuestions = [];
    let filteredQuestions = [];
    let currentQuestionIndex = 0;
    let correctAnswers = 0;
    let correctAnswersList = [];

    window.onload = function () {
      fetchQuestions();
    };

    function fetchQuestions() {
      fetch("https://the-trivia-api.com/api/questions")
        .then(response => response.json())
        .then(data => {
          allQuestions = data;
          displayCategories();
        })
        .catch(error => {
          console.error("error", error)
          alert("Internet disconnected or api not working.");
        } );
    }

    function displayCategories() {
      const categories = [...new Set(allQuestions.map(q => q.category))];
      const container = document.getElementById("category_container");

      for (let i = 0; i < categories.length; i += 2) {
        const row = document.createElement("div");
        row.className = "row";

        const category1 = document.createElement("div");
        category1.className = "box";
        category1.innerText = categories[i];
        category1.onclick = () => selectCategory(categories[i]);
        row.appendChild(category1);

        if (categories[i + 1]) {
          const category2 = document.createElement("div");
          category2.className = "box";
          category2.innerText = categories[i + 1];
          category2.onclick = () => selectCategory(categories[i + 1]);
          row.appendChild(category2);
        }

        container.appendChild(row);
      }
    }

    function selectCategory(category) {
      filteredQuestions = allQuestions.filter(q => q.category === category);
      console.log('filteredQuestions.length :', filteredQuestions.length);
      currentQuestionIndex = 0;
      correctAnswers = 0;
      correctQuestionList = [];
      correctAnswerList = [];
      

      document.getElementById("category_container").classList.add("hidden");
      document.getElementById("quiz-container").classList.remove("hidden");
      document.getElementById('smallbox_container').classList.remove("hidden");

      showQuestion();
    }

    function showQuestion() {
      if (currentQuestionIndex >= filteredQuestions.length) {
        showResults();
        return;
      }

      let timer; 
      const timeLimit = 30; 
      let timeRemaining = timeLimit;

      const timerElement = document.getElementById("timer_q");
      timeRemaining = timeLimit;
      if (timer) clearInterval(timer);

    timerElement.innerText = `${timeRemaining}`;

    timer = setInterval(() => {
      timeRemaining--;
      timerElement.innerText = `${timeRemaining}`;

      if (timeRemaining <= 0) {
        clearInterval(timer);
        nextQuestion(); 
      }
    }, 1000);

      const questionData = filteredQuestions[currentQuestionIndex];
      document.getElementById("question_text").innerText = questionData.question;

      const questionNumber = currentQuestionIndex + 1;
      console.log('questionNumber :', questionNumber);
      document.getElementById("question_number").innerText = questionNumber;

      const optionsContainer = document.getElementById("options-container");
      optionsContainer.innerHTML = "";

      const allOptions = [...questionData.incorrectAnswers, questionData.correctAnswer];
      allOptions.sort(() => Math.random() - 0.5); 

      for (let i = 0; i < allOptions.length; i++) {
        const option = document.createElement("div");
        option.className = "option";
        option.innerText = allOptions[i];
        option.onclick = () => checkAnswer(allOptions[i], questionData.correctAnswer);
        optionsContainer.appendChild(option);
      }
    }

    function checkAnswer(selected, correct) {
      if (correct) {
        correctAnswers++;
        correctQuestionList.push(filteredQuestions[currentQuestionIndex].question);
        correctAnswerList.push(correct);
      }
      nextQuestion();
    }

    function nextQuestion() {
      currentQuestionIndex++;
      showQuestion();
    }

    function showResults() {
      document.getElementById("quiz-container").classList.add("hidden");
      document.getElementById("result-container").classList.remove("hidden");
      document.getElementById('smallbox_container').classList.add("hidden");

      const score = (correctAnswers / filteredQuestions.length) * 100;

      const resultText = document.getElementById("result-text");
      if (score >= 50) {
        resultText.innerText = "Winner";
      } else if (score >= 40) {
        resultText.innerText = "Better";
      } else {
        resultText.innerText = "Failed";
      }

      const correctQuestionListElement = document.getElementById("correct-question-list");
      const correctAnswerListElement = document.getElementById("correct-answer-list");
      console.log('correctQuestionList : ', correctQuestionList);
      console.log('correctAnswerList : ', correctAnswerList);
      correctQuestionListElement.innerHTML = correctQuestionList
      .map(
          (question) => `
            <div class="correct-question-box">
              ${question}
            </div>
          `
        )
        .join("");
        correctAnswerListElement.innerHTML = correctAnswerList
      .map(
          (answer) => `
            <div class="correct-answer-box">
              ${answer}
            </div>
          `
        )
        .join("");
    }

    function restartQuiz() {
     //// fetchQuestions();
      document.getElementById("result-container").classList.add("hidden");
      document.getElementById("category_container").classList.remove("hidden");
      document.getElementById('smallbox_container').classList.add("hidden");
    }
  </script>
</body>
</html>
