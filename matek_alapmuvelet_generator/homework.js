function getDropDownListValue(name) {
    var list = document.getElementById(name);
    return list.options[list.selectedIndex].value;
  }
  
  function generateEquations(){
    var typeOfEquations = getDropDownListValue("typeOfEquations");
    var numberOfEquations = getDropDownListValue("numberOfEquations");
    var numberOfDigits = getDropDownListValue("numberOfDigits");
  
    var operand1, operand2, operator, equation, operators;
    switch(typeOfEquations) {
      case '1':
          operators=['+'];
          document.getElementById('title').innerHTML='Összeadások';
          break;
      case '2':
          operators=['-'];
          document.getElementById('title').innerHTML='Kivonások';  
          break;
      case '3':
          document.getElementById('title').innerHTML='Szorzások';
          operators=['x'];
          break;
      case '4':
          document.getElementById('title').innerHTML='Osztások';
          operators=[':'];
          break;      
      case '5':
          document.getElementById('title').innerHTML='Alapműveletek';
          operators=['+','-','x',':']
          break;
     }
  
    document.getElementById('worksheet').innerHTML = '';
   
     
    for (i = 1; i <= parseInt(numberOfEquations); i++) {
      operand1 = Math.floor((Math.random() * (Math.pow(10,numberOfDigits)+1)));
      operand2 = Math.floor((Math.random() * (Math.pow(10,numberOfDigits)+1)));
      operator = operators[Math.floor(Math.random() * operators.length)];
  
      equation = String(operand1) + ' ' + operator + ' ' + String(operand2) + ' =';
  
      document.getElementById('worksheet').innerHTML =  document.getElementById('worksheet').innerHTML + 
      '<div class=equation><span class=number>' +String(i) + ')&nbsp;&nbsp;&nbsp;</span>' + equation + '</div>';
    }
  }