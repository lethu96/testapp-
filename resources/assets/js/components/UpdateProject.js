import React, {Component} from 'react';
import axios from 'axios';
import { Link } from 'react-router';
import MyGlobalSettings from './MyGlobalSettings';


class UpdateProject extends Component
{
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


  componentDidMount(){
    axios.get('http://localhost:8000/project/edit/${this.props.params.id}')
    .then(response => {
      this.setState({ name: response.data.name, information: response.data.information,
        deadline: response.data.deadline,type: response.data.type,status: response.data.status});
    })
    .catch(function (error) {
      console.log(error);
    })
  }

    handleChange1(e){
        this.setState({
            name: e.target.value
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


  handleSubmit(event) {
    event.preventDefault();
    const project = {
      name: this.state.name,
      information: this.state.information,
      deadline: this.state.deadline,
      type: this.state.type,
      status: this.state.status
    }
    let uri = MyGlobleSetting.url + '/project/update'+this.props.params.id;
    axios.put(uri, project).then((response) => {
          this.props.history.push('/display-item');
    });
  }
  render(){
    return (
      <div>
        <h1>Update Project</h1>
        <div className="row">
          <div className="col-md-10"></div>
          <div className="col-md-2">
            <Link to="/display-item" className="btn btn-success">Return to Project</Link>
          </div>
        </div>
        <form onSubmit={this.handleSubmit}>

            <div className="form-group">
                <label>Project Name</label>
                <input type="text"
                className="form-control"
                value={this.state.name}
                onChange={this.handleChange1} />
            </div>

            <div className="form-group">
                <label name="product_body">Project Information</label>
                <textarea className="form-control"
                onChange={this.handleChange2} value={this.state.information}></textarea>  
            </div>

            <div className="form-group">
                <label>Project Deadline</label>
                <input type="date"
                className="form-control"
                value={this.state.deadline}
                onChange={this.handleChange3} />
            </div>

            <div className="form-group">
                <label>Project Type</label>
                <input type="text"
                className="form-control"
                value={this.state.type}
                onChange={this.handleChange4} />
            </div>

            <div className="form-group">
                <label>Project Status</label>
                <input type="text"
                className="form-control"
                value={this.state.status}
                onChange={this.handleChange5} />
            </div>

            <div className="form-group">
                <button className="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
    )
  }
}
export default UpdateProject;