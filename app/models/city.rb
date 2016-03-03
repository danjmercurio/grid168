# == Schema Information
#
# Table name: cities
#
#  id         :integer(4)      not null, primary key
#  city_name  :string(255)
#  state_id   :integer(4)
#  created_at :datetime
#  updated_at :datetime
#

class City < ActiveRecord::Base
  has_many :dmas
  belongs_to :state
end
