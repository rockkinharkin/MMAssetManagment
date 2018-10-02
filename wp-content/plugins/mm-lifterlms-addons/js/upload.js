( function(){
    var dropzone=document.getElementById('dropzone');
    console.log(dropzone);
    dropzone.ondragover = function(){
      this.className = 'dropzone dragover';
      return false;
    }
}());
