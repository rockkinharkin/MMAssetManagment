( function(){
    var dropzone=document.getElementById('dropzone');
    console.log(dropzone);
    dropzone.ondragenter = function(){
      this.className = 'dropzone dragover';
      return false;
    }
}());
