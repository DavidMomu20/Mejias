<!-- ======= Book A Table Section ======= -->
<section id="book-a-table" class="book-a-table">
    <div class="container" data-aos="fade-up">

        <div class="section-header">
            <h2>Reservar mesa</h2>
            <p>Rellene los <span>siguientes datos</span>, por  favor</p>
        </div>

        <div class="row g-0">

            <div class="col-lg-4 reservation-img" style="background-image: url(<?=base_url('assets/img/reservation.jpg')?>);" data-aos="zoom-out" data-aos-delay="200"></div>

            <div class="col-lg-8 d-flex align-items-center reservation-form-bg custom-width div-form-reserva" style="padding: 5% 0;">
            <form method="post">
                <div class="row">
                    <div class="col reserva-calendario">
                    <div class="date-reserva">
                        Elija un día:
                    </div>
                    <div class="calendar">
                        <div class="calendar-header">
                            <span class="prev-month">&#8249;</span>
                            <span class="current-month-year"></span>
                            <span class="next-month">&#8250;</span>
                        </div>
                        <div class="calendar-weekdays">
                            <span>Dom</span>
                            <span>Lun</span>
                            <span>Mar</span>
                            <span>Mie</span>
                            <span>Jue</span>
                            <span>Vie</span>
                            <span>Sab</span>
                        </div>
                        <div class="calendar-days">
                        </div>
                    </div>
                    </div>

                    <div class="col reserva-horas">
                        <div class="hours-reserva">
                            Elija una hora:
                        </div>
                        <div class="horas">
                            <div class="container">
                            <div class="row">
                                <div class="col-12">
                                <span>Comida:</span>
                                </div>   
                            </div>
                            <div class="row">
                                <div class="col-4 text-center">
                                    <button class="my-2">13:00</button>
                                </div>
                                <div class="col-4 text-center">
                                    <button class="my-2">13:30</button>
                                </div>
                                <div class="col-4 text-center">
                                    <button class="my-2">14:00</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4 text-center">
                                    <button class="my-2">14:30</button>
                                </div>
                                <div class="col-4 text-center">
                                    <button class="my-2">15:00</button>
                                </div>
                            </div>
                            <hr class="border">
                            <div class="row">
                                <div class="col-12">
                                    <span>Cena:</span>
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-4 text-center">
                                    <button class="my-2">20:00</button>
                                </div>
                                <div class="col-4 text-center">
                                    <button class="my-2">20:30</button>
                                </div>
                                <div class="col-4 text-center">
                                    <button class="my-2">21:00</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4 text-center">
                                    <button class="my-2">21:30</button>
                                </div>
                                <div class="col-4 text-center">
                                    <button class="my-2">22:00</button>
                                </div>
                                <div class="col-4 text-center">
                                    <button class="my-2">22:30</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4 text-center">
                                    <button class="my-2">23:00</button>
                                </div>
                                <div class="col-4 text-center">
                                    <button class="my-2">23:30</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col reserva-comensales text-center">
                        <div class="comensales">
                            <label for="n_comensales">¿Cuántas personas sois?</label>
                            <div class="inp-comensales">
                                <button class="bCount bMenos">-</button>
                                <input type="number" name="n_comensales" id="n_comensales" value="1" min="1" max="10">
                                <button class="bCount bMas">+</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 3rem;">
                    <div class="col text-center">
                        <button type="submit" id="bReservarMesa" class="btn-book-a-table" style="font-size: 1.3rem;">
                            Reservar
                        </button>
                    </div>
                </div>
                </form>

            </div><!-- End Reservation Form -->

        </div>

    </div>
</section><!-- End Book A Table Section -->

<script src="<?=base_url('assets/js/calendar.js')?>"></script>
<script src="<?=base_url('assets/js/makeReservaMesa.js')?>"></script>