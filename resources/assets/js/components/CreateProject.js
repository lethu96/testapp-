import React, {Component} from 'react';
import {browserHistory} from 'react-router';
import MyGlobleSetting from './MyGlobleSetting';


class CreateProject extends Component {
  constructor(props){
    super(props);
    this.state = {name: '', information: '', deadline: '', type: '', status: ''};
    this.handleChange1 = this.handleChange1.bind(this);
    this.handleChange2 = this.handleChange2.bind(this);
    this.handleChange3 = this.handleChange3.bind(this);
    this.handleChange4 = this.handleChange4.bind(this);
    this.handleChange5 = this.handleChange5.bind(this);
    this.handleSubmit = this.handleSubmit.bind(this);
    }

    handleChange1(e){
        this.setState({
            title: e.target.value
        })
    }

    handleChange2(e){
        this.setState({
            information: e.target.value
        })
    }

    handleChange3(e){
        this.setState({
            deadline: e.target.value
        })
    }

    handleChange4(e){
        this.setState({
            type: e.target.value
        })
    }

    handleChange5(e){
        this.setState({
            status: e.target.value
        })
    }

    handleSubmit(e){
        e.preventDefault();
        const project = {
            name: this.state.name,
            information: this.state.information,
            deadline: this.state.deadline,
            type: this.state.type,
            status: this.state.status
    }

    let uri = MyGlobleSetting.url + '/api/project';
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
                <input type="text" className="form-control" onChange={this.handleChange1} />
              </div>
            </div>
            </div>

         <div className="row">
            <div className="col-md-6">
              <div className="form-group">
                <label>Project information:</label>
                <input type="text" className="form-control" onChange={this.handleChange2} />
              </div>
            </div>
            </div>

          <div className="row">
            <div className="col-md-6">
              <div className="form-group">
                <label>Project deadline:</label>
                <input type="text" className="form-control" onChange={this.handleChange3} />
              </div>
            </div>
            </div>
          <div className="row">
            <div className="col-md-6">
              <div className="form-group">
                <label>Project type:</label>
                <input type="text" className="form-control" onChange={this.handleChange4s} />
              </div>
            </div>
            </div>
          <div className="row">
            <div className="col-md-6">
              <div className="form-group">
                <label>Project status:</label>
                <input type="text" className="form-control" onChange={this.handleChange5} />
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