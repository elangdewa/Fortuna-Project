pipeline {
  agent any

  stages {
    stage('Install Dependencies') {
  steps {
    bat 'composer install'
  }
}

stage('Run Tests') {
  steps {
    bat 'vendor\\bin\\phpunit'
  }
}
  }

  post {
    failure {
      echo 'Build Gagal!'
    }
  }
}
