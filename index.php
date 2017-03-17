<?php
    define('STUDENT_IMAGE_URL', 'http://192.168.1.43/other/draganddrop/images');
    $question_no = 1;
    $no_of_questions = 1;
    $PTActivity = array();
    $AllPTActivity = array();
    $word_hides_list = Array('5'=>'Pixel','6'=>'responsive','7'=>'feature','8'=>'level');
    $question_master = Array('QuestionMaster'=>Array('id' => '117','title' => 'Cloze 1','intro' => 'Intro'));
    $question = Array('Question' => Array('cloze_text' => 'Pixel perfect mobile responsive design and feature reach recruitment website technology us to deliver a bespoke recruitment website design on a structure that is highly flexible. Our own advanced and feature rich CMS system means that we build the best websites and then constantly update it. Delivering exceptional results, our technology will take your website to the next level.','id' => '1378','type_id' => '5','display' => '','marks' => 1,'hint' => ''),'QDifficultyLevel' => Array('title'=>'Easy'));
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Page Title</title>

        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <link rel="stylesheet" href="css/flatly/bootstrap.min.css"/>
        <link rel="stylesheet" href="css/jquery-ui.css">
        

        <script type="text/javascript" src="js/jquery-1.12.4.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui.js"></script>
        <script type="text/javascript" src="js/jquery.ui.touch-punch.min.js"></script>
        <script type="text/javascript" src="js/touche.min.js"></script>
        
        <style type="text/css">
            /* draggable targets */
            #divShuffle { margin-bottom: 5px;}
            #clozeText { line-height:30px; }

            #itemList.droppable{ 
                padding: 10px;
                width: 100%;
            }
            #itemList span.draggable{
                margin-right: 3px;
                padding: 5px;
                cursor: move;
            }
            #clozeText span.droppable{ 
                margin-right: 3px;
                padding: 0 20px;
            }
            #clozeText span.draggable{ 
                background: none;
                border: none;
                margin-right: 3px;
                cursor: move;
            }
            body {
              -webkit-touch-callout: none; /* iOS Safari */
                -webkit-user-select: none; /* Safari */
                 -khtml-user-select: none; /* Konqueror HTML */
                   -moz-user-select: none; /* Firefox */
                    -ms-user-select: none; /* Internet Explorer/Edge */
                        user-select: none; /* Non-prefixed version, currently
                                              supported by Chrome and Opera */
            }
        </style>

        <script type="text/javascript">
            
            var question_no = '<?php echo $question_no; ?>';
            var answer = '<?php echo @$PTActivity["answer"]; ?>';
            answer = answer.trim();
            
            $(document).ready(function() {

                draganddrop();

                //Record Activity
                if(answer != '')
                {
                    $("#linkSkip").hide();
                    $("#linkNext").show();
                }else{
                    $("#linkSkip").show();
                    $("#linkNext").hide();
                }

                $('body').on('change', 'input.chkFlag', function() {
                    //record_activity(question_no);
                    if($(this).is(':checked')){
                        $(this).parent('label').addClass('active');
                    }else{
                        $(this).parent('label').removeClass('active');
                    }
                });
                $('body').on('click', 'a.action', function() {
                    var action = $(this).attr('data-action');
                    $("#txtAction").val(action);
                    //record_activity(question_no);
                });

                update_answerList();
                update_itemList();
                update_droppable(); 
                //record_activity(question_no);
            });    

            function draganddrop() 
            {
                $( ".draggable" ).draggable({ 
                    revert: "invalid"
                });
                
                $( ".droppable" ).droppable({
                    accept: ".draggable",  
                    classes: {
                        "ui-droppable-active": "ui-state-active",
                        "ui-droppable-hover": "ui-state-hover"
                    },
                    /*over: function(event, ui) {
                    $(this).css('height','30px');
                    },
                    out: function(event, ui) {
                    $(this).css('height','30px');
                    },*/
                    drop: function( event, ui ) {
                        
                        /*if($( this ).attr('id') == 'itemList'){
                            $( this ).append(ui.draggable.css('left','0px').css('top','0px'));
                        }else{
                            $(this).html(ui.draggable.css('left','0px').css('top','0px'));
                        }*/

                        if($( this ).attr('id') == 'itemList'){
                            $( this ).append(ui.draggable.css('left','').css('top',''));
                        }else{
                            $(this).html(ui.draggable.css('left','').css('top',''));
                        }

                        update_answerList();
                        update_itemList();
                        update_droppable();
                        draganddrop();
                        //window.location.reload();
                    }
                });
            }
            function validateQuestion() 
            {
                var txtAnswerObj = $("#txtAnswer");
                if (txtAnswerObj.val().trim().length == 0) {
                    $(txtAnswerObj).val("");
                    $.growl.error({ message: "Please change the order as per blanks on the coze text" });
                    return false;
                }
                return true;     
            }

            function update_itemList()
            { 
                var obj = $("#divShuffle div#itemList span.draggable");
                var jsonWordHides = [];
                $.each(obj, function(i) {
                    jsonWordHides.push($(this).text());
                });
                $("#txtItem").val(jsonWordHides);
            }

            function update_answerList()
            { 
                var obj2 = $(".main_left_box div#clozeText span.draggable");
                var jsonAnswerList = [];
                $.each(obj2, function(i) {
                    if($(this).text().trim().length > 0)
                    {
                        jsonAnswerList.push($(this).text());    
                    }
                });
                $("#txtAnswer").val(jsonAnswerList);
                if(jsonAnswerList.length > 0)
                {
                    $("#linkSkip").hide();
                    $("#linkNext").show();
                }else{
                    $("#linkSkip").show();
                    $("#linkNext").hide();
                }
            }

            function update_droppable() 
            {
                var obj2 = $(".main_left_box div#clozeText span.droppable");
                $.each(obj2, function(i) {
                    if($(this).find("span.draggable").length >= 1){
                        $(this).droppable( "option", "disabled", true );
                        $( this ).addClass( "ui-state-highlight" );
                    }else{
                        $(this).droppable( "option", "disabled", false );
                        $( this ).removeClass( "ui-state-highlight" );    
                    }
                    $(this).removeClass('ui-droppable-active');
                    $(this).removeClass('ui-state-active');
                });
                $("#txtClozeText").val($("#clozeText").html());
            }

        </script>
    </head>
    <body>
        <div class="container">
            <div class="row">

                <input type="hidden" id="txtQuestionNo" name="data[question_no]" value="<?php echo $question_no; ?>">
                <input type="hidden" id="txtQuestionMasterId" name="data[question_master_id]" value="<?php echo $question_master['QuestionMaster']['id']; ?>">
                <input type="hidden" id="txtQuestionId" name="data[question_id]" value="<?php echo $question['Question']['id']; ?>">

                <div class="background-color page-title">
                    <h1 class="heading-title">
                        <?php echo $question_master['QuestionMaster']['title']; ?>
                        <?php if(isset($question_master['QuestionMaster']['intro']) && !empty($question_master['QuestionMaster']['intro'])){ ?>    
                            <span><?php echo nl2br($question_master['QuestionMaster']['intro']); ?></span>
                        <?php } ?>
                    </h1>
                </div>

                <?php if(isset($question['Question']['cloze_text']) && !empty($question['Question']['cloze_text'])){ ?>

                    <div class="main_left_box">
                        <?php
                            $dbClozeText = nl2br(trim($question['Question']['cloze_text']));
                            $wordHidesList = $word_hides_list;
                            $wordHidesArr = array_values($wordHidesList);
                            $itemArr = array();

                            $itemArr = $wordHidesArr;
                            if(isset($PTActivity["item"]))
                            {
                                if(strlen(trim($PTActivity["item"])))
                                {
                                    $itemArr = array();
                                    $itemArr = explode(',', $PTActivity["item"]);        
                                }
                            }
                            
                            
                            $answerArr = array();
                            if(isset($PTActivity["answer"]))
                            {
                                if(strlen(trim($PTActivity["answer"])))
                                {
                                    $answerArr = explode(',', $PTActivity["answer"]);        
                                }
                            }

                            if( !isset($PTActivity["cloze_text"]) || strlen(trim($PTActivity["cloze_text"])) == 0 )
                            {
                                $cloze_text = $dbClozeText;
                                foreach ($itemArr as $key => $word) 
                                {
                                    if(in_array( $word, $answerArr ) == false)
                                    {
                                        $cloze_text = preg_replace("/\b$word\b/u", "<span class='droppable ui-widget-header'></span>", $cloze_text, 1);
                                    }
                                }
                            } 
                            else
                            {
                                $cloze_text = $PTActivity["cloze_text"];
                            }

                            $cloze_text = trim($cloze_text);
                        ?>
                        <div id="clozeText" class="panel-body">
                            <?php echo $cloze_text; ?>    
                        </div>
                    </div>

                <?php } ?>   

                <div class="main_left_box"> 
                    <div class="Timeduration"><?php echo $question_no; ?></div>
                    <div class="panel-body">
                        <div class="Questionname">

                            <h3>
                                <span class="Markspq <?php echo $question['QDifficultyLevel']['title']; ?>"><em>Difficulty</em><?php echo $question['QDifficultyLevel']['title']; ?></span>
                                <span class="Markspq"><em>Marks</em><?php echo ($question['Question']['marks'] * count($wordHidesArr)); ?></span>
                            </h3>

                            <?php
                                shuffle($wordHidesArr);  

                                //print_r($wordHidesArr);

                                $itemHtml =  "<div id='itemList' class='droppable ui-widget-header'>";
                                $itemArr = array();
                                foreach ($wordHidesArr as $key => $word) 
                                {
                                    if(in_array( $word, $answerArr ) == false)
                                    {
                                        $itemHtml .= "<span class='draggable ui-widget-content'>$word</span>";
                                        array_push($itemArr, $word);
                                    }
                                    else
                                    {
                                        array_push($answerArr, $word);
                                    }
                                }
                                $itemHtml .= "</div>";
                                $itemHtml = trim($itemHtml);


                                if( !isset($PTActivity["item"]) || strlen(trim($PTActivity["item"])) == 0 )
                                {
                                    $itemString = implode(',', $itemArr);    
                                } 
                                else
                                {
                                    $itemString = trim($PTActivity["item"]);
                                }


                                if( !isset($PTActivity["answer"]) || strlen(trim($PTActivity["answer"])) == 0 )
                                {
                                    $answerString = implode(',', $answerArr);
                                } 
                                else
                                {
                                    $answerString = trim($PTActivity["answer"]);
                                }
                            ?>

                            <div class="Anset clozeWord">
                                <div id="divShuffle">
                                    <?php echo $itemHtml; ?>
                                </div>
                            </div>

                            <div class="Hint">
                                <p>Note: Drag the words into the boxes to complete the sentences. If you want to change already placed words, simply drag the word to another box.</p>
                            </div>

                            <input type="text" name="data[cloze_text]" id="txtClozeText" value="<?php echo trim(@$PTActivity['cloze_text']); ?>">
                            <input type="text" name="data[item]" id="txtItem" value="<?php echo trim($itemString); ?>">
                            <input type="text" name="data[answer]" id="txtAnswer" value="<?php echo trim($answerString); ?>">
                            <input type="hidden" name="data[action]" id="txtAction" value="<?php echo @$PTActivity['action']; ?>">

                            

                        </div>
                    </div>
                </div>
            </div>     
        </div>    
    </body>
</html>
 
