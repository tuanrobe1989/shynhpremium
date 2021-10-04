<?php get_header() ?>
<section class="appointment">
<h1 class="appointment__title maintit"><?php the_title(); ?></h1>
  <div class="container appointment__container">
    <form action="" method="POST" class="appointment__register">        
        <div class="appointment__register__wrapper">        
        <div class="appointment__register__input-wrapper"><input type="text" class="appointment__register__input" placeholder="Full Name">
        </div>
        <div class="appointment__register__input-wrapper"><input type="text" class="appointment__register__input" placeholder="Phone">
        </div>
        <div class="appointment__register__input-wrapper">
          <select class="appointment__register__input">
            <option value="volvo">Services</option>
            <option value="saab">Saab</option>
            <option value="opel">Opel</option>
            <option value="audi">Audi</option>
          </select>
        </div> 
        <div class="appointment__register__input-wrapper"><input type="text" class="appointment__register__input" placeholder="Date">
        </div>
        <div class="appointment__register__input-wrapper"><input type="text" class="appointment__register__input" placeholder="Time">
        </div>               
        <div class="appointment__register__area-wrapper">
        <textarea name="message" id="txtarea" cols="30" rows="5" class="appointment__register__input area-input" placeholder="Message"></textarea>
        </div>
        </div>
        <div class="appointment__register__submit-wrapper">
        <input type="submit" value="BOOK NOW" class="appointment__register__submit">
        </div>
        <p class="appointment__register__time-window">Monday - Thurday:8:00am - 11:00am / 2:00pm - 5:00pm / 7:00pm - 9:30pm </p>
        <p class="appointment__register__time-window">Monday - Friday to Sunday:9:00am - 11:30am / 2:00pm - 5:30pm / 7:00pm - 10:00pm </p>
    </form>
    <div class="appointment__image-wrapper">
      <img src="<?php echo imageEncode('/images/appointment1.webp');?>" alt="" title="" class="appointment__image1">
      <img src="<?php echo imageEncode('/images/appointment2.webp');?>" alt="" title="" class="appointment__image2">
    </div>    
  </div>
</section>
<?php get_footer() ?>