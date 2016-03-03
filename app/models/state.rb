# == Schema Information
#
# Table name: states
#
#  id         :integer(4)      not null, primary key
#  name       :string(255)
#  created_at :datetime
#  updated_at :datetime
#

class State < ActiveRecord::Base
  has_many :cities
end
