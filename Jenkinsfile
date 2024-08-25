pipeline {
    agent any
    environment {
        APP_ENV = 'local'
        DB_CONNECTION = 'mysql'
        DB_PORT = '3306'
        DB_PASSWORD = credentials('DB_PASSWORD')
        DB_USERNAME = credentials('DB_USERNAME')
        DB_DATABASE = 'laravel'
        MAIL_MAILER = 'smtp'
        MAIL_FROM_NAME = 'Laravel'
        MAIL_ENCRYPTION = credentials('MAIL_ENCRYPTION')
        MAIL_FROM_ADDRESS = credentials('MAIL_FROM_ADDRESS')
        MAIL_HOST = credentials('MAIL_HOST')
        MAIL_PASSWORD = credentials('MAIL_PASSWORD')
        MAIL_PORT = credentials('MAIL_PORT')
        MAIL_USERNAME = credentials('MAIL_USERNAME')
    }
    stages {
        stage('Create Network') {
            steps {
                script {
                    sh 'docker network create mailing_service || true'
                }
            }
        }

        stage('Build and Start Mailing Service') {
            steps {
                script {
                    sh 'docker-compose up -d --build'
                }
            }
        }

        stage('Wait Before Testing') {
            steps {
                script {
                    // Wait for 60 seconds
                    sh 'sleep 60'
                }
            }
        }

        stage('Verify Services') {
            steps {
                script {
                    sh 'docker-compose ps'
                }
            }
        }

        stage('Run Python Selenium Tests') {
            steps {
                script {
                    docker.image('selenium/node-chrome-debug').inside {
                        sh '''
                        apt-get update
                        apt-get install -y python3-venv python3-pip

                        python3 -m venv myenv
                        chmod +x myenv/bin/activate
                        ./myenv/bin/activate

                        myenv/bin/pip install selenium pytest
                        '''
                        sh 'myenv/bin/python3 test_sendemail.py'
                    }
                }
            }
        }
    }

    post {
        always {
            script {
                // Clean up services
                sh 'docker-compose down'
            }
        }
    }
}
