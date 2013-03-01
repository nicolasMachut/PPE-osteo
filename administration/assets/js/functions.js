function generateRandomPassword(limit) {
  
    limit = limit || 4;
  
    var password = 'osteo';
    var i = 0;
    var numbers = ["1","2","3","4","5","6","7","8","9","0"];
    var len = numbers.length;
    
    do {
      i++;
      var index = Math.floor(Math.random() * len);
      password += numbers[index];
    } while(i < limit);
    
    return password;
};