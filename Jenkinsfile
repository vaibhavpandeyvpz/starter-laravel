pipeline {
  agent any
  parameters {
    string(
      name: 'DOCKERHUB_USERNAME',
      defaultValue: ''
    )
    password(
      name: 'DOCKERHUB_TOKEN',
      defaultValue: ''
    )
    string(
      name: 'DOCKER_IMAGE',
      defaultValue: ''
    )
  }
  stages {
    stage('Check code-style') {
      steps {
        sh 'docker run --rm -v $PWD:/workspace syncloudsoftech/pinter pint --test'
      }
    }
    stage('Build and push') {
      steps {
        sh 'docker login -u $DOCKERHUB_USERNAME -p $DOCKERHUB_TOKEN'
        sh 'docker build -t ${params.DOCKER_IMAGE}:$BUILD_NUMBER .'
        sh 'docker push ${params.DOCKER_IMAGE}:$BUILD_NUMBER'
      }
    }
  }
}
