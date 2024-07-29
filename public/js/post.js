$('select').each(function () {
  $(this).select2({
    theme: 'bootstrap4',
    width: 'style',
    tags: true,
    placeholder: $(this).attr('placeholder'),
    allowClear: Boolean($(this).data('allow-clear')),
  });
});
// Valid Image
document.querySelector(".img_up_fi").addEventListener("change", () => {
    const fileInput = document.getElementById('image');
    const file = fileInput.files[0];
    if (file) {
        document.querySelector(".img .error").textContent="";
        if (!['image/jpeg', 'image/png', 'image/gif'].includes(file.type)) {
            document.querySelector(".img .error").textContent="Invalid file type. Only JPEG, PNG, and GIF are allowed.";
        } else {
          // Validate file size
          if (file.size > (3 * 1024 * 1024)) {
            document.querySelector(".img .error").textContent="File size exceeds the maximum limit of 3MB.";
          } else {
            const img = new Image();
            img.src = URL.createObjectURL(file);
            img.onload = function() {
                const width = img.naturalWidth;
                const height = img.naturalHeight;
                console.log(width);
                console.log(height);
                URL.revokeObjectURL(img.src);
                // Validate image dimensions
                if (width >= 700 && height >= 400) {
                    // Show image preview
                    const previewImg = document.getElementById('previewImg');
                    previewImg.src = URL.createObjectURL(file);
                } else {
                    document.querySelector(".img .error").textContent="Image dimensions should be at least 700X400 pixels";
                }
            }
            img.onerror = function() {
                alert('Error: Invalid image file.');
            }
          }
        } 
    } else {
      // document.querySelector(".img .error").textContent="No file selected.";
    }
})