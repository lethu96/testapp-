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
                <h1>SHOW MEMBER</h1>
                <form >
                    <div className="col-md-6">
                        <div className="row">
                            <div className="col-md-10">
                                <div className="form-group">
                                    <label>Name :</label>
                                    {this.state.name}
                                </div>
                            </div>
                        </div>
                        <div className="row">
                            <div className="col-md-10">
                                <div className="form-group">
                                    <label>Birthday :</label>
                                    {this.state.birthday}
                                </div>
                            </div>
                        </div>
                        <div className="row">
                            <div className="col-md-10">
                                <div className="form-group">
                                <label>Information :</label>
                                {this.state.information}
                            </div>
                            </div>
                        </div>
                        <div className="row">
                            <div className="col-md-10">
                                <div className="form-group">
                                <label>Phone Number :</label>
                                {this.state.phone_number}
                            </div>
                            </div>
                        </div>
                        <div className="row">
                            <div className="col-md-10">
                                <div className="form-group">
                                    <label>Gender :</label>
                                    {this.state.gender}
                                </div>
                            </div>
                        </div>
                        <div className="row">
                            <div className="col-md-10">
                                <div className="form-group">
                                    <label>Position :</label>
                                    <select value={this.state.selectedposition} className="form-control" disabled >
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
