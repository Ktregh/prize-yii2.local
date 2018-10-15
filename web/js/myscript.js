jQuery(document).ready(function($)
{
    var type = 0;
    $('#start').click(function()
    {
        $('#startbutton').remove();
        var images = [{
            url: "/web/img/1.png", // Картинка
            timeout: 200 // Задержка для картинки
        }, {
            url: "/web/img/2.png", // Картинка
            timeout: 200
        }, {
            url: "/web/img/3.png", // Картинка
            timeout: 200
        }],
        i = 0,
        z = 0,
        timeout;
        function changeImg()
        {
            clearTimeout(timeout);
            $('#imgprize').attr('src', function() {
                if (i >= images.length)
                {
                   i = 0;
                   z++;
                }
                timeout = setTimeout(changeImg, images[i].timeout);
                if(z < 5)
                {
                    return images[i++].url; 
                }
            });
        }
        changeImg();        
        setTimeout(function ()
        {
                getPrize();
        }, 3);
        function getPrize()
        {
            $.ajax
            ({
                url: '/site/prizes',
                type: 'POST',
                data:
                {
                    firststep:'yes'
                },
                success: function(data)
                {
                    console.log(data);
                    type = data.type;
                    prize = data.prize;
                    result = data.result;
                    bonus = data.bonus;
                    getPrize2();
                },
                error: function()
                {
                    alert('Что-то пошло не так!');
                }
            });
        }
        function getPrize2()
        {
            switch(type)
            {
               case 1:
                   $('#imgprize').attr('src', '/img/1.png');
                   $('#textp').html('Вы выиграли денежный приз - ' + prize + ' денег!');
                   $('#moneydiv').css({'display' : 'block'});
                   break;
                case 2:
                    $('#imgprize').attr('src', '/img/2.png');
                    $('#textp').html('Вы выиграли баллы - ' + prize + ' баллов! У Вас на счету ' + bonus + ' баллов!');
                    $('#bonus').html(bonus);
                    $('#mainbutton').css({'display' : 'block'});
                    break;
                case 3:
                    $('#imgprize').attr('src', '/img/3.png');
                    $('#textp').html('Вы выиграли приз - ' + prize);
                    $('#prizediv').css({'display' : 'block'});
                    break;
               default:
                     break;
           }
       }
    }); 
    $('#changemoney').click(function()
    {
        $.ajax
        ({
            url: '/site/change-money',
            type: 'POST',
            success: function(data)
            {
                var result = data.result;
                var bonus = data.bonus;
                alert(data.prize);
                $('#bonus').html(bonus);
                $('#textp').html(result + '. У Вас на счету ' + bonus + ' баллов!');
                $('#mainbutton').css({'display' : 'block'});
                $('#moneydiv').remove();
            },
            error: function()
            {
                alert('Что-то пошло не так!');
            }
        });
    });
    $('#getmoney').click(function()
    {
        $.ajax
        ({
            url: '/controllers/AjaxController.php',
            type: 'POST',
            dataType: 'json',
            data:
            {
                getmoney:'yes'
            }
         }).done(function(data)
         {
            var result = data.result;
            $('#textp').html(result);
            $('#mainbutton').css({'display' : 'block'});
            $('#moneydiv').remove();
        });
    });
    $('#getthing').click(function()
    {
        $.ajax
        ({
            url: '/controllers/AjaxController.php',
            type: 'POST',
            dataType: 'json',
            data:
            {
                getthing:'yes'
            }
         }).done(function(data)
         {
            var result = data.result;
            $('#textp').html(result);
            $('#mainbutton').css({'display' : 'block'});
            $('#prizediv').remove();
        });
    });
    $('#refusething').click(function()
    {
        
        $('#textp').html('Вы отказались от приза (');
        $('#mainbutton').css({'display' : 'block'});
        $('#prizediv').remove();
        
    });
});