let Custom = {
    init: () => {
        Custom.showModal();
        Custom.closeModal();
    },
    logout: () => {
        Alert.confirm('question', 'خروج از برنامه', 'مایل به خروج از برتامه می باشید', function () {
            Livewire.emit('logout');
        });
    },
    modalShow: (id) => {
        Livewire.emit('callModal', id);
    },
    showModal: () => {
        window.addEventListener('showModal', (event) => {
            let {name} = event.detail;
            $('#' + name).modal();
        });
    },
    closeModal: () => {
        window.addEventListener('closeModal', (event) => {
            let {name} = event.detail;
            $('#' + name).modal('hide');
        });
    },
    deleteItemList: (id, called) => {
        Alert.confirm('question', 'آیتم حذف شود؟', 'تایید حذف',
            function () {
                let call_method = (called === undefined) ? 'destroy' : called;
                console.log(call_method);
                console.log(id);
                Livewire.dispatch(call_method, { id: id});
            }
        )
    },
    deleteAllItems: (called) => {
        Alert.confirm('question', 'تمام آیتم ها حذف شوند؟', 'تایید حذف',
            function () {
                let call_method = (called === undefined) ? 'deleteAll' : called;
                console.log(call_method);
                Livewire.dispatch(call_method);
            }
        )
    }
};
Custom.init();

// Makes the clicked image full screen (uses a <div> with a background image)
$('.img-full-screen').click(function(){
            
    // Prevents scrolling
    $('body').addClass('scroll-disabled');
    
    // Optional: Enables pinch and zoom
    $('meta[name=viewport]').attr('content','width = device-width, initial-scale = 1.00, minimum-scale = 1.00, maximum-scale = 2.00, user-scalable=yes');
    
    // Get image path source
    let imagePath = $(this).attr('src');
    
    // Set image path source
    $('.img-placeholder').attr('style','background-image: url(' + imagePath + ')');
    
    // Show image
    $('.img-placeholder').fadeIn();
    
});

$('.img-placeholder').click(function(){

    // Enables scrolling again
    $('body').removeClass('scroll-disabled');

    // Optional: Disables pinch and zoom
    $('meta[name=viewport]').attr('content','width = device-width, initial-scale = 1.00, minimum-scale = 1.00, maximum-scale = 1.00');

    // Hide image
    $('.img-placeholder').fadeOut();
});