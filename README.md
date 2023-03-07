# Quran Tadabor Quiz App
## Demo
Try the app in action live here: https://tadabor-quiz.netlify.app/

## Introduction
This is basically a simple SPA that people may use to challenge themselves in understanding verses of the Holy Quran. 

The original source of the quiz is a book created by Dr.‪Eyad Qunaibi‬ and published in [Noon Online Bookstore](https://www.noor-book.com/%D9%83%D8%AA%D8%A7%D8%A8-%D9%85%D8%AA%D8%B9%D9%87-%D8%A7%D9%84%D8%AA%D8%AF%D8%A8%D8%B1-pdf). 

## Project stages

1. Data entry: A team has entered the content of the book in a structured way inside multiple Google Sheets files.
2. Data cleaning: I reviewed the sheets to make sure data is cleaned and in a consistent format to be consumed by the code later.
3. Data preparing: I exported the sheets as tsv files. I tried using csv but Google Sheet didn't quote the data properly, which broke the file structure when a cell contained some commas.
4. Data conversion: I wrote a [PHP script](./converter/convert.php) that converted the tsv files into JSON in the desired format. These JSON files will be later consumed directly by the Vue.js app. In addition, I wrote [another PHP script](./converter/meta-builder.php) that converted some meta data related to the quiz. 
5. Implementation: The actual app that reads JSON files, shows the questions, and handles the logic of evaluating user's answers.



## Project setup
```
npm install
```

### Compiles and hot-reloads for development
```
npm run serve
```

### Compiles and minifies for production
```
npm run build
```

### Lints and fixes files
```
npm run lint
```

### Customize configuration
See [Configuration Reference](https://cli.vuejs.org/config/).
