jQuery(document).ready(function($) {
    var result = 0;
    var operation;

    $(".btn-act").click(function() {
        if(result == 0) {
            result = parseInt($(this).val());
        }
        $value = $(".calc-output").val();
        $(".calc-output").val($value + " " + $(this).val());

        switch(operation) {
            case "+":
                result += parseInt($(this).val());
                break;
            case "-":
                result -= parseInt($(this).val());
                break;
        }

        if($(this).hasClass('btn-op')) {
            operation = $(this).val();
        }
    });

    $(".btn-equals").click(function() {
        $(".calc-output").val(result);
    })
});