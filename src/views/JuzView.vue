<script>
  import Vue from "vue";
import * as juzs from "../../converter/json/v2/";
import juzsMeta from "../../converter/meta/juzs.json";
import surasMeta from "../../converter/meta/suras.json";

export default {
  setup() {
    
  },
  mounted() {
    // console.log(this.juzMeta);
    
    
  },
  created() {
    console.log("created");

    //Response to changing the Router parameter
    this.$watch(
      () => this.$route.params,
      (toParams, previousParams) => {
        console.log(toParams, previousParams);
        this.juzNumber = toParams.id;
        this.questions = juzs[toParams.id];
        this.juzMeta = juzsMeta[toParams.id -1 ]; // -1 To fix the index
        this.choices = [];
        this.wrongAnswers = [];
        this.showResults = false;
      }
    )
    
  },
  data() {
    return {
      juzNumber: this.$route.params.id,
      questions: juzs[this.$route.params.id],
      juzMeta: juzsMeta[this.$route.params.id - 1], // -1 to fix the index
      surasMeta,
      choices: [],
      wrongAnswers: [], //Holds indicies of questions with wrong answers
      showResults: false,
    }
  },
  methods: {
    /**
     * Compares the user choices against the provided answers array
     * If the user choice matches any of the accepted answers, the choice is considered correct
     */
    evaluate() {
      this.wrongAnswers = [];
      //Loop over all questions in the json file.
      for (let i=0; i<this.questions.length; i++) {
        let answers = this.questions[i].answers;
        let choice = this.choices[i];
        let correct = false;

        //If the user has submitted an answer for this question
        if (typeof choice !== 'undefined') {
          //If the user choice of sura and verse matches any accepted answer
          if (answers.find(e => e.sura == choice.sura && e.verse == choice.verse)) 
            correct = true;
        }
        
        //If incorrect, and not pushed before to the array
        if (!correct && !this.wrongAnswers.includes(i)) 
          this.wrongAnswers.push(i);
      }
      this.showResults = true;
      setTimeout(function(){window.scrollTo(0, document.body.scrollHeight);}, 50);
      
    },
    /**
     * Updates the choices array with sura verse
     */
    updateChoices(index, type, event) {
      if (typeof this.choices[index] === 'undefined') {
        Vue.set(this.choices, index, {sura: '', verse: ''});
      }
      this.choices[index][type] = event.target.value;
    },
  },
  computed: {
    wrongScore() {
      return this.wrongAnswers.length;
    },
    totalScore() {
      return this.questions.length;
    },
    correctScore() {
      return this.totalScore - this.wrongScore;
    }
  }

}
</script>
<template>
  <div class="juz-block container">
    <h1>الجزء رقم: {{juzNumber}}</h1>
    <table>
      <tr v-for="(q, index) in questions" :key="index" class="question-row" :class="{danger: wrongAnswers.includes(index)}">
        <td class="question-number">{{index+1}}</td>
        <td class="question-cell">
          <p>{{q.text}}</p>
          <select @change="updateChoices(index, 'sura', $event)">
            <option value="0">اختر سورة</option>
            <option v-for="n,i in juzMeta.suraCount" :key="i" :value="juzMeta.startSura + n - 1">{{juzMeta.startSura + n - 1}} - {{surasMeta[juzMeta.startSura + n - 1 -1].name}}</option>
          </select>
          <select v-if="choices[index] && choices[index].sura !== ''" @change="updateChoices(index, 'verse', $event)">
            <option>اختر رقم الآية</option>
            <option v-for="n in surasMeta[choices[index].sura-1]['ayaCount']" :key="n">{{n}}</option>
          </select>
          <p class="correct-answer" v-if="showResults" v-html="q.answerText"></p>
        </td>
      </tr>
    </table>
    <br />
    <p v-if="showResults" class="result">حصلت على {{correctScore}} إجابة صحيحة من أصل {{totalScore}} سؤال</p>
    <button class="evaluate-btn btn" @click="evaluate()">تقييم</button>

  </div>
</template>
<style >
  body {
    direction: rtl;
  }
  .container {
    max-width: 900px;
    margin: auto;
  }
  .question-row {
    background-color: #e1dfff;
  }
  .question-row.danger {
    background-color: #ffdada;
  }
  .question-number {
    width: 20px;
  }
  .question-cell {
    padding:10px
  }
  .question-cell select {
    padding: 10px;
    background: #edf2ff;
    border: none;
    margin: 0 10px;
  }
  .btn {
  background: #3498db;
  background-image: -webkit-linear-gradient(top, #3498db, #2980b9);
  background-image: -moz-linear-gradient(top, #3498db, #2980b9);
  background-image: -ms-linear-gradient(top, #3498db, #2980b9);
  background-image: -o-linear-gradient(top, #3498db, #2980b9);
  background-image: linear-gradient(to bottom, #3498db, #2980b9);
  -webkit-border-radius: 28;
  -moz-border-radius: 28;
  border-radius: 28px;
  font-family: Arial;
  color: #ffffff;
  font-size: 20px;
  padding: 10px 20px 10px 20px;
  text-decoration: none;
}

.btn:hover {
  background: #3cb0fd;
  background-image: -webkit-linear-gradient(top, #3cb0fd, #3498db);
  background-image: -moz-linear-gradient(top, #3cb0fd, #3498db);
  background-image: -ms-linear-gradient(top, #3cb0fd, #3498db);
  background-image: -o-linear-gradient(top, #3cb0fd, #3498db);
  background-image: linear-gradient(to bottom, #3cb0fd, #3498db);
  text-decoration: none;
}
.correct-answer {
  border: solid 1px #3aa503;
  padding: 10px;
  max-width: 700px;
  margin: 10px auto;
  border-radius: 10px;
  background: #ccf5b3;
}
.correct-answer strong {
  color: #2c8100;
}
.danger .correct-answer {
  border: solid 1px red;
  background: #f5b3c8;
}
.danger .correct-answer strong {
  color: #720d0d;
}
</style>