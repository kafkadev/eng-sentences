/*console.log('bigjs installed')
console.log(document.title)


    document.addEventListener('copy', (e) => {
      e.preventDefault();
      var text = window.getSelection().toString()

      console.log(text, 'copy action initiated')
  });

    document.addEventListener('mousedown', (e) => {
      //e.preventDefault();
      var text = window.getSelection().toString()

    //  console.log(text, 'mousedown action initiated')
  });

    document.addEventListener('mouseup', (e) => {
      //e.preventDefault();
      var text = window.getSelection().toString()
if (text.trim()) {

     console.log(text, 'mouseup action initiated')
};
  });
    document.addEventListener('dblclick', (e) => {
      //e.preventDefault();
      var text = window.getSelection().toString()

      console.log(text, 'dblclick action initiated')
  });

    document.body.addEventListener('select', (e) => {
      e.preventDefault();
      var text = window.getSelection().toString()


      console.log(text, 'select action initiated')
  });
    document.body.addEventListener('selectionchange', (e) => {
      e.preventDefault();

      var text = window.getSelection().toString()
      console.log(text, 'selectionchange action initiated')
  });

    document.body.addEventListener('keyup', (e) => {
      e.preventDefault();

      var text = window.getSelection().toString()
      console.log(text, 'keyup action initiated')
  });
    document.addEventListener('copy', (event) => {
        const selection = document.getSelection();
        event.clipboardData.setData('text/plain', selection.toString().toUpperCase());
        event.preventDefault();
    });


*/
                            window.addEventListener("message", function (e) {
                                console.log(e.data);

                            });
