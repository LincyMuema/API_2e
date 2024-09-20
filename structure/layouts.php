<?php
    class layouts{
        public function heading(){
            ?>
         <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Document</title>
                <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">-->
                <link href="css/bootstrap.css" rel="stylesheet">
            </head>
            <body>
            <?php
        }
        function banner(){
            ?>
              <div class="p-3 mb-4 bg-body-tertiary rounded-3">
                <div class="container-fluid py-2">
                  <h1 class="display-5 fw-bold">Assignemnt II</h1>
                  <p class="col-md-8 fs-4">This is an individual assignment. We assume that you already know how to set up a localhost server(s): & MySQL database and Apache web servers.<br>If not, your instructor will assist you to set it up.  </p>
                  <button class="btn btn-primary btn-lg" type="button">Example button</button>
                </div>
              </div>
            <?php
        }
        public function footer(){
            ?>
             <footer class="pt-3 mt-4 text-body-secondary border-top">
                &copy; 2024
              </footer>
            </div>
          </main>
      </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
        <?php
        }
    }