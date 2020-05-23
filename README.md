## Installation

### Frontend
``` cd frontend```  
``` cp .env.example .env```  
``` npm install```  
``` npm run serve```  

### Backend
``` cp .env.example .env```  
``` composer install```   
``` php artisan storage:link```    
``` php artisan migrate:fresh --seed```   
``` php artisan jwt:secret```   
``` php artisan serve --port 8000```  

Set also your mailer credentials.

### Seeded Organizer Credentials
- organizer@organizer.com / 123456


