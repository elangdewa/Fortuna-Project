pipeline {
  agent any

  stages {
    stage('Install Dependencies') {
      steps {
        bat 'composer install'
        bat 'npm install'
        bat 'npm run build'
      }
    }

    stage('Copy .env') {
      steps {
        bat 'copy .env.testing .env'
      }
    }

    stage('Generate App Key') {
      steps {
        bat 'php artisan key:generate'
      }
    }

    stage('Migrate Test DB') {
      steps {
        bat 'php artisan migrate:fresh --force'
      }
    }

    stage('Run Tests') {
      steps {
        bat 'php artisan test'
      }
    }
  }

  post {
    success {
      echo 'Build Berhasil!'
    }
    failure {
      echo 'Build Gagal!'
    }
  }
}
