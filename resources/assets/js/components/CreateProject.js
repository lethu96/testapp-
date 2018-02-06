import React, {Component} from 'react';
import {browserHistory} from 'react-router';

class CreateProject extends Component
{
    constructor(props) {
        super(props);
        this.state = {name: '', information: '', deadline: '', type: '', status: ''};
        this.ChangeProjectName = this.ChangeProjectName.bind(this);
        this.ChangeProjectInformation = this.ChangeProjectInformation.bind(this);
        this.ChangeProjectDeadline = this.ChangeProjectDeadline.bind(this);
        this.ChangeProjectType = this.ChangeProjectType.bind(this);
        this.ChangeProjectStatus = this.ChangeProjectStatus.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    ChangeProjectName(e) {
        this.setState({
            name: e.target.value
        })
    }

    ChangeProjectInformation(e) {
        this.setState({
            information: e.target.value
        })
    }

    ChangeProjectDeadline(e){
        this.setState({
            deadline: e.target.value
        })
    }

    ChangeProjectType(e) {
        this.setState({
            type: e.target.value
        })
    }

    ChangeProjectStatus(e) {
        this.setState({
            status: e.target.value
        })
    }

    handleSubmit(e) {
        e.preventDefault();
        const project = {
            name: this.state.name,
            information: this.state.information,
            deadline: this.state.deadline,
            type: this.state.type,
            status: this.state.status
    }

    let uri = 'http://test.thu/project/create';
    axios.post(uri, project).then((response) => {
      browserHistory.push('/display-item');
    });
  }


    render() {
      return (
      <div>
        <h1>Create project</h1>
        <form onSubmit={this.handleSubmit}>
          <div className="row">
            <div className="col-md-6">
              <div className="form-group">
                <label>Project name:</label>
                <input type="text" className="form-control" onChange={this.ChangeProjectName} />
              </div>
            </div>
            </div>

         <div className="row">
            <div className="col-md-6">
              <div className="form-group">
                <label>Project information:</label>
                <input type="text" className="form-control" onChange={this.ChangeProjectInformation} />
              </div>
            </div>
            </div>

          <div className="row">
            <div className="col-md-6">
              <div className="form-group">
                <label>Project deadline:</label>
                <input type="text" className="form-control" onChange={this.ChangeProjectDeadline} />
              </div>
            </div>
            </div>
          <div className="row">
            <div className="col-md-6">
              <div className="form-group">
                <label>Project type:</label>
                <input type="text" className="form-control" onChange={this.ChangeProjectType} />
              </div>
            </div>
            </div>
          <div className="row">
            <div className="col-md-6">
              <div className="form-group">
                <label>Project status:</label>
                <input type="text" className="form-control" onChange={this.ChangeProjectStatus} />
              </div>
            </div>
            </div>
            <div className="form-group">
              <button className="btn btn-primary">Add project</button>
            </div>
        </form>
  </div>
      )
    }
}
export default CreateProject;