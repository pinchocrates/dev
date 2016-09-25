require 'sinatra'
require 'sinatra/reloader' if development?

# get '/' do
#  xname = "Frank Robinson III"
#  myarray = [1,2,4,8,16,32]
#  "Hello #{xname} darling asasasasas ... FLY ME TO THE MOOOOON"
# end

get '/:name' do  
  name = params[:name]
  "Hi there #{name}!"
 end