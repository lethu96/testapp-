import React, {Component} from 'react';
import {Link,browserHistory} from 'react-router';


class ShowDetailMember extends Component
{
    constructor(props)
    {
        super(props);
        this.state = {
            position: '',
            selectedposition: '',
            name: '',
            information: '',
            phone_number: '',
            birthday: '',
            gender: '',
            position_id:'',
            avatar:'',
            error:'',
            position_name:''
        };
    }

    componentDidMount()
    {
        axios.get('http://localhost:8000/positions').then(response => {
            this.setState({ position: response.data });
        })
        .catch(function (error) {
            console.log(error);})
        let current_url = window.location.href;
        let current_id = current_url.split("/").pop();
        axios.get('http://localhost:8000/member/edit/' + current_id)
        .then(response=> {
            this.setState({ name: response.data.name, information: response.data.information,
                birthday: response.data.birthday, gender: response.data.gender, phone_number: response.data.phone_number,
                avatar: response.data.avatar,selectedposition: response.data.position_id});
            console.log(this.state.avatar)
        })
        .catch(function (error) {
            console.log(error);
        })
    }

    showPosition()
    {
        if (this.state.position instanceof Array) {
            return this.state.position.map(function (position) {
                return (<option key={position.id} value={position.id}>{position.name}</option>);
            })
        }
    }

    render()
    {
        return (
            <div>
                <h1>Show Detail Member</h1>
                <form >
                    <div className="col-md-6">
                        <div className="row">
                            <div className="col-md-10">
                                <div className="form-group">
                                    <label>Name</label>
                                    <input value={this.state.name} type="text" className="form-control" disabled />
                                </div>
                            </div>
                        </div>
                        <div className="row">
                            <div className="col-md-10">
                                <div className="form-group">
                                    <label>birthday</label>
                                    <input value={this.state.birthday} type="date" className="form-control" disabled />
                                </div>
                            </div>
                        </div>
                        <div className="row">
                            <div className="col-md-10">
                                <div className="form-group">
                                <label>Information</label>
                                <textarea value={this.state.information}className="form-control col-md-6" disabled ></textarea>
                            </div>
                            </div>
                        </div>
                        <div className="row">
                            <div className="col-md-10">
                                <div className="form-group">
                                <label>Phone Number</label>
                                <input value={this.state.phone_number}className="form-control col-md-6" disabled />
                            </div>
                            </div>
                        </div>
                        <div className="row">
                            <div className="col-md-10">
                                <div className="form-group">
                                    <label>Gender</label>
                                    <select value={this.state.gender} className="form-control" disabled >
                                        <option value="">---Option---</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                    <p className="help-block" >{this.state.error.gender} </p>
                                </div>
                            </div>
                        </div>
                        <div className="row">
                            <div className="col-md-10">
                                <div className="form-group">
                                    <label>Position </label>
                                    <select value={this.state.selectedposition} className="form-control" disabled >
                                        <option value="">---Option---</option>
                                        {this.showPosition()}
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div className="form-group">
                            <Link to="/display-item-member" className="btn btn-success">List Member</Link>
                        </div>
                    </div>
                    <div className="col-md-6">
                        <div className="row">
                            <div className="col-md-6">
                                <div className="form-group">
                                <label>Avatar</label>
                            </div>
                            <img width="300px" height="300px" src={this.state.avatar}/>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        )
    }
}
export default ShowDetailMember;
